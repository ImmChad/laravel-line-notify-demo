@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins:after {
            height: 0px;

        }
        .content-send-notification {
            padding: 20px;
            margin-top: 40px;
            justify-content: space-between;
        }
        #btn-back-page {
            position: absolute;
            right: 10px;
            top: 10px;
            display: flex;
            justify-content: center;
            align-content: center;
            cursor: pointer;
            border-radius: 10px;
            padding: 10px;
            background: rgba(115, 102, 255, 0.08);
            color: #7366ff;
            width: max-content;
        }

        #btn-back-page {
            position: absolute;
            right: 10px;
            top: 10px;
            display: flex;
            justify-content: center;
            align-content: center;
            cursor: pointer;
            border-radius: 10px;
            padding: 10px;
            background: rgba(115, 102, 255, 0.08);
            color: #7366ff;
        }

        .section-select-type .dropdown {
            width: max-content;
        }

        .part-select-params {
            margin: 10px 0px;
            width: max-content;
        }

        .part-select-params .dropdown {
            width: max-content;
        }

        .part-select-params .dropdown-toggle {
            width: 100%;
            margin-right: 20px;
            min-width: 180px;
        }

        .section-template {

            position: relative;
        }

        .part-select-template {
            background: white;
            position: absolute;
            right: 10px;
            top: 10px;
            border-radius: 10px;
        }

        .section-select-type .dropdown-toggle, .part-select-template .dropdown-toggle {
            width: 100%;
            margin-right: 20px;
        }

        .part-preview-template .ipt-content-template {
            width: 100%;
            height: 100%;
            min-height: 300px;
            padding: 30px;
            resize: none;
            border-radius: .5rem;
            border: 3px solid var(--theme-deafult);
        }

        .part-preview-template .ipt-content-template::-webkit-scrollbar {
            display: none;
        }

        .section-option-others {
            margin: 10px 0px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .section-option-others .col {
            display: flex;
            flex-direction: column;
        }

        .btn-tick-send {
            border: 2px solid #51bb25;
            color: black;
        }

        .btn-tick-send:hover {
            border: 2px solid #51bb25 !important;
            background: #51bb25 !important;
            color: black;
        }

        .btn-send {
            border: 2px solid var(--theme-deafult);
            color: var(--theme-deafult);
        }

        .btn-send:hover {
            background: var(--theme-deafult);
            color: white;
        }
        .section-table-notification-draft
        {
            /*margin-bottom: 10px;*/
            /*max-height: 164px;*/
            /*overflow: auto;*/
        }
        .section-list-btn
        {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }
        .section-preview-notification
        {
            width: max-content;
            max-width: 289px;
            height: max-content;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
            border-radius: 30px;
            min-height: 460px;
            margin-left: 20px;
            display: flex;
            justify-content: center;
            padding: 16px;
        }
        .section-table-notification-draft table td
        {
            text-align: right;
        }
        .header-section-table-notification-draft
        {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-section-table-notification-draft .comment-header
        {
            font-weight: bolder;
            font-style: italic;
            color: #a927f9;
        }

    </style>


    <div class="row"
         style="display: flex; justify-content: center; align-items: center; padding: 0rem 0rem !important; margin: 0px !important;">
        <div class="col" style="padding: 0px;">
            <div class="card height-equal">
                <div class="row content-send-notification">
                    <div id="btn-back-page">Back</div>
                    <div class="col-7 section-table-notification-draft">
                        <div class="header-section-table-notification-draft">
                            <h1 class="title-header">Your options</h1>
                            <span class="comment-header">Campaign check success!</span>
                        </div>
                        <table class="table">
                            <thead class="thead-dark">
                            </thead>
                            <tbody>
                            <tr class="template-box" template_id="afb186d1-c323-4863-b2f5-c223b9734b1e">
                                <th scope="row">Notification ID</th>
                                <td>Store</td>
                            </tr>
                            <tr class="template-box" template_id="afb186d1-c323-4863-b2f5-c223b9734b1e">
                                <th scope="row">Notification created at</th>
                                <td>Store</td>
                            </tr>
                            <tr class="template-box" template_id="afb186d1-c323-4863-b2f5-c223b9734b1d">
                                <th scope="row">Notification title</th>
                                <td>This is title </td>
                            </tr>
                            <tr class="template-box" template_id="afb186d1-c323-4863-b2f5-c223b9734b1d">
                                <th scope="row">Number of recipients</th>
                                <td>30</td>
                            </tr>
                            <tr class="template-box" template_id="afb186d1-c323-4863-b2f5-c223b9734b1d">
                                <th scope="row">Number of Email needed</th>
                                <td>5</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="section-list-btn">
                            <button type="button" class="btn btn-light">Cancel</button>
                            <button type="button" class="btn btn-info">Edit</button>
                            <button type="button" class="btn btn-primary">Send</button>
                        </div>
                    </div>

                    <div class="col-2 section-preview-notification">
                        <style>
                            @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400);

                            .container {
                                width: 400px;
                                padding: 10px;
                            }

                            .message-blue {
                                position: relative;
                                margin-left: 20px;
                                margin-bottom: 10px;
                                padding: 10px;
                                background-color: #A8DDFD;
                                width: 90%;
                                height: max-content;
                                text-align: left;
                                font: 400 0.9em 'Open Sans', sans-serif;
                                border: 1px solid #97C6E3;
                                border-radius: 10px;
                                padding-bottom: 20px;
                            }

                            .message-content {
                                padding: 0;
                                margin: 0;
                            }

                            .message-timestamp-left {
                                position: absolute;
                                font-size: .85em;
                                font-weight: 300;
                                bottom: 5px;
                                left: 5px;
                            }

                            .message-blue:after {
                                content: '';
                                position: absolute;
                                width: 0;
                                height: 0;
                                border-top: 15px solid #A8DDFD;
                                border-left: 15px solid transparent;
                                border-right: 15px solid transparent;
                                top: 0;
                                left: -15px;
                            }

                            .message-blue:before {
                                content: '';
                                position: absolute;
                                width: 0;
                                height: 0;
                                border-top: 17px solid #97C6E3;
                                border-left: 16px solid transparent;
                                border-right: 16px solid transparent;
                                top: -1px;
                                left: -17px;
                            }

                            .message-orange:after {
                                content: '';
                                position: absolute;
                                width: 0;
                                height: 0;
                                border-bottom: 15px solid #f8e896;
                                border-left: 15px solid transparent;
                                border-right: 15px solid transparent;
                                bottom: 0;
                                right: -15px;
                            }

                            .message-orange:before {
                                content: '';
                                position: absolute;
                                width: 0;
                                height: 0;
                                border-bottom: 17px solid #dfd087;
                                border-left: 16px solid transparent;
                                border-right: 16px solid transparent;
                                bottom: -1px;
                                right: -17px;
                            }
                        </style>
                        <div class="container">
                            <div class="message-blue">
                                <p class="message-content">This is an awesome message!</p>
                                <div class="message-timestamp-left">SMS 13:37</div>
                            </div>
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

    <script>

        {{--let dataTemplate = document.querySelector('#dataTemplate');--}}
        {{--dataTemplate.addEventListener('change', (e) => {--}}
        {{--    let template_id = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('template_id');--}}
        {{--    let template_name = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('template_name');--}}


        {{--    if(template_id != 0) {--}}
        {{--        var form  = new FormData();--}}
        {{--        form.append('template_id', template_id);--}}


        {{--        $.ajaxSetup({--}}
        {{--            headers: {--}}
        {{--                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--            }--}}
        {{--        });--}}
        {{--        $.ajax({--}}
        {{--            url: '{{URL::to("/admin/get-template-for-send-mail")}}',--}}
        {{--            method: 'post',--}}
        {{--            data: form,--}}
        {{--            contentType: false,--}}
        {{--            processData: false,--}}
        {{--            dataType: 'json',--}}
        {{--            success: function(data) {--}}


        {{--                var announce_content = CKEDITOR.instances['announce_content'];--}}
        {{--                let newDiv = `${data.template_content}`;--}}
        {{--                announce_content.insertHtml(newDiv);--}}

        {{--                document.querySelector('#announce_title').value = data.template_title;--}}

        {{--            },--}}
        {{--            error: function() {--}}
        {{--                displayToast('Can not add data!');--}}
        {{--            }--}}
        {{--        });--}}
        {{--    } else {--}}

        {{--    }--}}
        {{--})--}}


        let btnBackPage = document.querySelector('#btn-back-page');
        btnBackPage.addEventListener('click', (e) => {
            window.location.href = "/admin/notification-list";
        });


        // let btnSendIt = document.querySelector('.btn-send-it');
        // btnSendIt.addEventListener('click', (e)=> {
        //     e.preventDefault();
        //
        //
        //     $('.parent-form-popup').css("display", "flex");
        //     $('.parent-form-popup .title-popup').text("Do you want to schedule to send it? If not, it will send now.");
        //
        //
        //     let newHtml = `
        //     <input class="form-control digits" id="example-datetime-local-input" type="datetime-local"  data-bs-original-title="" title="">
        //     <button class="btn btn-info send-notification" notification_type="3" style="margin-top: 1rem;">SEND IT</button>
        //     `;
        //
        //
        //     // document.querySelector('.parent-form-popup .faq-form').insertAdjacentHTML('beforeend', newHtml);
        //     document.querySelector('.parent-form-popup .faq-form').innerHTML = newHtml;
        //
        //
        //     let sendNotification = document.querySelector('.send-notification');
        //     sendNotification.addEventListener('click', (e) => {
        //         var editorData = CKEDITOR.instances.announce_content.getData();
        //         let notification_type = e.currentTarget.getAttribute('notification_type');
        //         sendNotificationOnService(notification_type, editorData);
        //     });
        //
        //
        //     $('.parent-form-popup .close-popup').click(function() {
        //         $('.parent-form-popup').css("display", "none");
        //     });
        //
        //
        //     $('#created_at').each(function () {
        //         $(this).datetimepicker();
        //     });
        //
        //
        // });


        {{--function sendNotificationOnService(notification_type, editorData) {--}}
        {{--    const now = new Date();--}}
        {{--    const formattedDate = new Intl.DateTimeFormat('en-US', {--}}
        {{--        year: 'numeric',--}}
        {{--        month: '2-digit',--}}
        {{--        day: '2-digit',--}}
        {{--        hour: '2-digit',--}}
        {{--        minute: '2-digit',--}}
        {{--        second: '2-digit',--}}
        {{--        hour12: false,--}}
        {{--    }).format(new Date(now));--}}


        {{--    const [month, day, year, ...time] = formattedDate.split(/[\s/:]/);--}}
        {{--    const newFormattedDate = `${year}/${month}/${day} ${time.join(":")}`;--}}
        {{--    let newDate = newFormattedDate.replace(',', "");--}}


        {{--    let created_at = $('#example-datetime-local-input').val();--}}
        {{--    let announce_content = editorData;--}}
        {{--    let announce_title = $('#announce_title').val();--}}
        {{--    // let span = document.createElement('span')--}}
        {{--    // span.innerHTML = announce_content--}}
        {{--    // let lengthText = span.textContent.length;--}}
        {{--    let [dateChoose, timeChoose] = newDate.split(' ');--}}
        {{--    let [hourChoose, minuteChoose, secondChoose] = timeChoose.split(':');--}}
        {{--    let newHour = hourChoose.replace('24', '00');--}}


        {{--    newDate = dateChoose + " " + newHour + ":" + minuteChoose + ":" + secondChoose;--}}


        {{--    let diffInSeconds = "";--}}


        {{--    if(created_at.trim() != "") {--}}
        {{--        const date1 = new Date(newDate);--}}
        {{--        const date2 = new Date(created_at);--}}
        {{--        diffInSeconds = (date2 - date1) / 1000;--}}
        {{--        console.log(newDate);--}}
        {{--        console.log(created_at);--}}
        {{--        console.log(diffInSeconds);--}}
        {{--    } else {--}}
        {{--        created_at = 0;--}}
        {{--        diffInSeconds = 0;--}}
        {{--    }--}}
        {{--    if(diffInSeconds < 0) {--}}
        {{--        displayToast("Can't enter this date in the past to set the timer!")--}}
        {{--    } else {--}}
        {{--        if(announce_title.trim() != "" && announce_content.trim() != "") {--}}
        {{--            // console.log(created_at + " " + announce_title + " " + announce_content);--}}


        {{--            console.log(notification_type);--}}
        {{--            console.log(announce_title);--}}
        {{--            console.log(announce_content);--}}
        {{--            console.log(created_at);--}}
        {{--            console.log(diffInSeconds);--}}






        {{--            var form  = new FormData();--}}
        {{--            form.append('message', announce_content);--}}
        {{--            form.append('title', announce_title);--}}
        {{--            form.append('delayTime', diffInSeconds);--}}
        {{--            form.append('scheduled_at', created_at);--}}
        {{--            form.append('type_notification', notification_type);--}}


        {{--            $.ajaxSetup({--}}
        {{--                headers: {--}}
        {{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--                }--}}
        {{--            });--}}
        {{--            $.ajax({--}}
        {{--                url: '{{URL::to("/admin/send-mess")}}',--}}
        {{--                method: 'post',--}}
        {{--                data: form,--}}
        {{--                contentType: false,--}}
        {{--                processData: false,--}}
        {{--                dataType: 'json',--}}
        {{--                success: function(data) {--}}

        {{--                    window.location.href = "/admin/send-notification-view/3?messToast=Send Success!";--}}

        {{--                },--}}
        {{--                error: function() {--}}
        {{--                    displayToast('Can not add data!');--}}
        {{--                }--}}
        {{--            });--}}
        {{--        } else {--}}
        {{--            displayToast("Please, Enter full!");--}}
        {{--        }--}}
        {{--    }--}}


        {{--}--}}
    </script>
    <script>
        // const dropdowns = document.querySelectorAll(".dropdown");
        // dropdowns.forEach(dropdown=>{
        //     const dropdownItems = dropdown.querySelectorAll(".dropdown-item");
        //     dropdownItems.forEach(dropdownItems=>{
        //         dropdownItems.addEventListener("click",(event)=>{
        //             dropdown.textContent = dropdownItems.textContent
        //         })
        //     })
        // })
    </script>
@endsection




































