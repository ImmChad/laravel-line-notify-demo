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
        <div class="col-sm-12 col-lg-6 col-xl-8 xl-50 col-md-12 box-col-6">
            <div class="card height-equal">
                <div class="card-header">
                    <h5>Notification</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                        <li class="return-notification-list"><i data-feather="corner-down-left" style="cursor: pointer;"></i></li>
                        </ul>
                    </div>
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

    <script>
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
            <button class="btn btn-info send-notification" notification_type="2" style="margin-top: 1rem;">SEND IT</button>
            `;

            // document.querySelector('.parent-form-popup .faq-form').insertAdjacentHTML('beforeend', newHtml);
            document.querySelector('.parent-form-popup .faq-form').innerHTML = newHtml;

            let sendNotification = document.querySelector('.send-notification');
            sendNotification.addEventListener('click', (e) => {
                let notification_type = e.currentTarget.getAttribute('notification_type');
                sendNotificationOnService(notification_type);
            });

            $('.parent-form-popup .close-popup').click(function() {
                $('.parent-form-popup').css("display", "none");
            });

            $('#created_at').each(function () {
                $(this).datetimepicker();
            });

        });

        function sendNotificationOnService(notification_type) {
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
            let announce_content = $('#announce_content').val();
            let announce_title = $('#announce_title').val();

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
                displayToast("Cann't enter this date in the past to set the timer!")
            } else {
                if(announce_title.trim() != "" && announce_content.trim() != "") {
                    // console.log(created_at + " " + announce_title + " " + announce_content);

                    // console.log(notification_type);
                    // console.log(announce_title);
                    // console.log(announce_content);
                    // console.log(created_at);
                    // console.log(diffInSeconds);



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
                            window.location.href = "/admin/send-notification-view/2?messToast=Send Success!";
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
    {{-- display calendar --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script> --}}


@endsection









    {{-- <div style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column; background: #f0f1f6">
        <div class="row" style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: flex-start; padding: 1rem; background: #f0f1f6"">
            <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card scroll-card" style=" height: calc(100vh - 2rem); overflow-y: scroll;">
                        <div class="card-body">
                            <div style="display: flex;justify-content: space-between">
                                <div class="card-title col-sm-12" style="font-size: 20px; font-weight: 700; padding: 0px; border: 2px solid black; border-radius: 0.2rem;">

                                    <input type="text" class="form-control" id="announce_title" placeholder="Enter announce title ... ">
                                </div>
                            </div>

                            <div class="card-title col-sm-12 scroll-card" style="font-size: 20px; font-weight: 700; padding: 0px; border: 2px solid black; border-radius: 0.2rem; height: 350px; overflow-y: scroll;">
                                <span class="announce_content" style="padding: 0rem;">
                                    <textarea class="form-control input-ads scroll-card" id="announce_content" style="width: 100%; height: 100%; resize: none;" placeholder="Enter announce content ..."></textarea>
                                </span>
                            </div>


                            <div style="display: flex;justify-content: space-between">
                                <div class="card-title col-sm-12" style="font-size: 20px; font-weight: 700; padding: 0px;  border-radius: 0.2rem;">
                                    <button id="submit-btn"  type="submit" class="btn btn-primary btn-submit-notify btn-send-mess">Send Announce</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}



    {{-- display calendar --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script >
        $('#created_at').each(function () {
            $(this).datetimepicker();
        });
    </script> --}}
















