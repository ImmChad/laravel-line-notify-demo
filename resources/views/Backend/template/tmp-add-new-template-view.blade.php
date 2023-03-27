@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins:after
        {
            height: 0px;
        }
        .content-send-notification
        {
            padding: 20px;
        }
        .section-select-type
        {
            margin-left: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        #btn-back-page
        {
            position: absolute;
            right: 10px;
            top: 10px;
            display: flex;
            justify-content: center;
            align-content: center;
            cursor: pointer;
        }
        .section-select-type .dropdown
        {
            width: max-content;
        }
        .section-params
        {
            display: flex;
            justify-content: space-between;
        }
        .part-select-params
        {
            width: max-content;
        }
        .part-select-params .dropdown
        {
            width: max-content;
        }
        .part-select-params .dropdown-toggle
        {
            width: 100%;
            margin-right: 20px;
            min-width: 180px;
        }
        .section-template
        {

            position: relative;
        }
        .section-select-type .dropdown-toggle, .part-select-template .dropdown-toggle
        {
            width: 100%;
            margin-right: 20px;
        }
        .part-input-text-template
        {
            width: 100%;
            height: 100%;
            padding: 30px;
        }
        .field-ipt-text
        {
            margin-bottom: 10px;
        }
        .ipt-text-notification
        {
            width: 100%;

        }
        .section-option-btn
        {
            margin: 10px 0px;
            display: flex;
            align-items: center;
        }
        .part-list-btn-template
        {
            flex: 1;
        }
        .btn-add-template
        {
            display: flex;
            align-items: center;
            width: max-content;
        }
        .part-list-btn-send
        {

            width: 50%;
            display: flex;
            flex-wrap: wrap;
        }
        .btn-opt-add-template
        {
            margin-right: 20px;
            margin-bottom: 20px;
            min-width: 180px;
        }
    </style>
    <div class="row" style="display: flex; justify-content: center; align-items: center;">
        <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 box-col-12">
            <div class="card height-equal">
                <div class="content-send-notification">
                    <div id="btn-back-page"><i data-feather="arrow-left-circle"></i>Back</div>
                    <div class="section-select-type">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="ipt-select-type" data-bs-toggle="dropdown" aria-expanded="false">
                                Please select type
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="ipt-select-type">
                                <li><span class="dropdown-item" >Store</span></li>
                                <li><span class="dropdown-item" >User</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="section-template">
                        <div class="part-input-text-template">
                            <div class="field-ipt-text field-title->notification">
                                <input class="ipt-text-notification" id="ipt-title-notification">
                            </div>
                            <div class="field-ipt-text field-content->notification">
                                <textarea class="ipt-text-notification"id="ipt-content-notification"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="section-params">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Please input new param</th>
                                <th scope="col">Please input meaning of the param</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>region_nm</td>
                                <td>Region name</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>shop_id</td>
                                <td>Shop Name</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="section-option-btn">
                        <div id="btn-cancel-new-template" class="btn btn-primary btn-opt-add-template">
                            Cancel
                        </div>
                        <div id="btn-save-new-template" class="btn btn-primary btn-opt-add-template">
                            Save
                        </div>
                    </div>
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




































