@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .dropdown-item
        {
            cursor: pointer;
        }
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
            width: max-content;
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
            border-radius: 10px;
            padding: 10px;
            background: rgba(115, 102, 255, 0.08);
            color: #7366ff;
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
            margin: 10px 0px;
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
        .part-select-template
        {
            background: white;
            position: absolute;
            right: 10px;
            top: 10px;
            border-radius:10px ;
        }
        .section-select-type .dropdown-toggle, .part-select-template .dropdown-toggle
        {
            width: 100%;
            margin-right: 20px;
        }
        .part-preview-template .ipt-content-template
        {
            width: 100%;
            height: 100%;
            min-height: 300px;
            padding: 30px;
            resize: none;
            border-radius: .5rem;
            border: 3px solid var(--theme-deafult);
        }
        .part-preview-template .ipt-content-template::-webkit-scrollbar
        {
            display: none;
        }
        .section-option-others
        {
            margin: 10px 0px;
            display: flex;
            align-items: center;
        }
        .part-list-btn-template
        {
            flex: 1;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .btn-add-template
        {
            display: flex;
            align-items: center;
            width: max-content;
            width: max-content;
            height: max-content;
        }
        .part-list-btn-send
        {

            width: 50%;
            display: flex;
            flex-wrap: wrap;
        }
        .btn-opt-send
        {
            margin-right: 20px;
            margin-bottom: 20px;
            min-width: 180px;
            width: 100%;
        }
        .section-option-others .col
        {
            display: flex;
            flex-direction: column;
        }
    </style>
    <div class="row" style="display: flex; justify-content: center; align-items: center;">
        <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 box-col-12">
            <div class="card height-equal">
                <div class="content-send-notification">
                    <div id="btn-back-page">Back</div>
                    <div class="section-select-type">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Please select type</option>
                            <option value="1">User</option>
                            <option value="2">Store</option>
                        </select>
                    </div>
                    <div class="section-template">
                        <div class="part-select-template">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Please select template</option>
                                <option value="1">template 1</option>
                                <option value="2">template 2</option>
                            </select>
                        </div>
                        <div class="part-preview-template">
                            <div class="ipt-content-template" data-cke-editable="false" contenteditable="true" id="ipt-content-notification">before <button id="alo" contenteditable="false" >Alo</button> after
                            </div>

                        </div>

                    </div>



                    <div class="section-option-others">
                        <div class="row">
                            <div class="col">
                                <div class="part-select-params">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Open this select menu</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="part-list-btn-template">
                                    <div class="btn btn-primary btn-add-template" id="btn-add-template">
                                        Add Templates
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="part-select-params">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Open this select menu</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="part-select-params">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Open this select menu</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div id="btn-send-schedule" class="btn btn-primary btn-opt-send">
                                    Send with schedule
                                </div>
                                <div id="btn-show-main-scheduled" class="btn btn-primary btn-opt-send">

                                    List  mail scheduled
                                </div>
                            </div>
                            <div class="col">
                                <div class="part-select-params">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Open this select menu</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div id="btn-send-now" class="btn btn-primary btn-opt-send">

                                    Send now
                                </div>

                                <div id="btn-show-main-send" class="btn btn-primary btn-opt-send">

                                    List mail send
                                </div>
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

    <script src="{{asset('assets/js/email-app.js')}}"></script>


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


        let returnNotificationList = document.querySelector('.return-notification-list');
        returnNotificationList.addEventListener('click', (e)=>{
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




































