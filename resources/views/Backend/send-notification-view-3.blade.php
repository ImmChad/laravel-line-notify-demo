@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins:after
        {
            height: 0px;
        }
    </style>
    {{-- <div class="title-manager">
    <h1 class="text-title-manager" >Table Register Notification Line</h1>
    </div> --}}


    <div class="row" style="display: flex; justify-content: center; align-items: center;">
        <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 box-col-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h5>Notification</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li class="return-notification-list"><i data-feather="corner-down-left" style="cursor: pointer;"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-header" style="padding: 0px 40px;">
                    <select class="form-select digits" id="dataTemplate" >
                        <option template_id="0" template_name="null">Choose Template</option>
                        @foreach ($dataTemplate as $subDataTemplate)
                            <option template_id="{{ $subDataTemplate->id }}" template_name="{{ $subDataTemplate->template_name }}">{{ $subDataTemplate->template_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="contact-form card-body">
                    <form class="theme-form">
                        <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                        <div class="mb-3">
                            <label for="exampleInputName">Notification title</label>
                            <input class="form-control" id="announce_title" type="text"
                                placeholder="John Dio">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="exampleInputEmail1">Notification content</label>


                            <textarea class="form-control textarea" id="announce_content" rows="3" cols="50" placeholder="Your Message"></textarea>
                        </div>
                        <div class="text-sm-end">
                            <button class="btn btn-primary-gradien btn-send-it">SEND IT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    {{-- display calendar --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script> --}}




@endsection


@section('script')
    <script src="{{asset('assets/js/editor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{asset('assets/js/email-app.js')}}"></script>


    <script>

        let dataTemplate = document.querySelector('#dataTemplate');
        dataTemplate.addEventListener('change', (e) => {
            let template_id = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('template_id');
            let template_name = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('template_name');


            if(template_id != 0) {
                var form  = new FormData();
                form.append('template_id', template_id);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{URL::to("/admin/get-template-for-send-mail")}}',
                    method: 'post',
                    data: form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {


                        var announce_content = CKEDITOR.instances['announce_content'];
                        let newDiv = `${data.template_content}`;
                        announce_content.insertHtml(newDiv);

                        document.querySelector('#announce_title').value = data.template_title;

                    },
                    error: function() {
                        displayToast('Can not add data!');
                    }
                });
            } else {

            }
        })


        let returnNotificationList = document.querySelector('.return-notification-list');
        returnNotificationList.addEventListener('click', (e)=>{
            window.location.href = "/admin/notification-list";
        });


        let btnSendIt = document.querySelector('.btn-send-it');
        btnSendIt.addEventListener('click', (e)=> {
            e.preventDefault();


            $('.parent-form-popup').css("display", "flex");
            $('.parent-form-popup .title-popup').text("Do you want to schedule to send it? If not, it will send now.");


            let newHtml = `
            <input class="form-control digits" id="example-datetime-local-input" type="datetime-local"  data-bs-original-title="" title="">
            <button class="btn btn-info send-notification" notification_type="3" style="margin-top: 1rem;">SEND IT</button>
            `;


            // document.querySelector('.parent-form-popup .faq-form').insertAdjacentHTML('beforeend', newHtml);
            document.querySelector('.parent-form-popup .faq-form').innerHTML = newHtml;


            let sendNotification = document.querySelector('.send-notification');
            sendNotification.addEventListener('click', (e) => {
                var editorData = CKEDITOR.instances.announce_content.getData();
                let notification_type = e.currentTarget.getAttribute('notification_type');
                sendNotificationOnService(notification_type, editorData);
            });


            $('.parent-form-popup .close-popup').click(function() {
                $('.parent-form-popup').css("display", "none");
            });


            $('#created_at').each(function () {
                $(this).datetimepicker();
            });


        });


        function sendNotificationOnService(notification_type, editorData) {
            const now = new Date();
            const formattedDate = new Intl.DateTimeFormat('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
            }).format(new Date(now));


            const [month, day, year, ...time] = formattedDate.split(/[\s/:]/);
            const newFormattedDate = `${year}/${month}/${day} ${time.join(":")}`;
            let newDate = newFormattedDate.replace(',', "");


            let created_at = $('#example-datetime-local-input').val();
            let announce_content = editorData;
            let announce_title = $('#announce_title').val();
            // let span = document.createElement('span')
            // span.innerHTML = announce_content
            // let lengthText = span.textContent.length;
            let [dateChoose, timeChoose] = newDate.split(' ');
            let [hourChoose, minuteChoose, secondChoose] = timeChoose.split(':');
            let newHour = hourChoose.replace('24', '00');


            newDate = dateChoose + " " + newHour + ":" + minuteChoose + ":" + secondChoose;


            let diffInSeconds = "";


            if(created_at.trim() != "") {
                const date1 = new Date(newDate);
                const date2 = new Date(created_at);
                diffInSeconds = (date2 - date1) / 1000;
                console.log(newDate);
                console.log(created_at);
                console.log(diffInSeconds);
            } else {
                created_at = 0;
                diffInSeconds = 0;
            }
            if(diffInSeconds < 0) {
                displayToast("Can't enter this date in the past to set the timer!")
            } else {
                if(announce_title.trim() != "" && announce_content.trim() != "") {
                    // console.log(created_at + " " + announce_title + " " + announce_content);


                    console.log(notification_type);
                    console.log(announce_title);
                    console.log(announce_content);
                    console.log(created_at);
                    console.log(diffInSeconds);






                    var form  = new FormData();
                    form.append('message', announce_content);
                    form.append('title', announce_title);
                    form.append('delayTime', diffInSeconds);
                    form.append('scheduled_at', created_at);
                    form.append('type_notification', notification_type);


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{URL::to("/admin/send-mess")}}',
                        method: 'post',
                        data: form,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {

                            window.location.href = "/admin/send-notification-view/3?messToast=Send Success!";

                        },
                        error: function() {
                            displayToast('Can not add data!');
                        }
                    });
                } else {
                    displayToast("Please, Enter full!");
                }
            }


        }





    </script>
@endsection




































