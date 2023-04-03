@extends('admin.notification.backend-view')
@section('ContentAdmin')
    <style>
        #preview-mess-content-notification table,
        #preview-mess-content-notification td
        {width: 220px !important;}
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

        .section-table-notification-draft {
            /*margin-bottom: 10px;*/
            /*max-height: 164px;*/
            /*overflow: auto;*/
        }

        .section-list-btn {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .section-preview-notification {
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

        .section-table-notification-draft table td {
            text-align: right;
        }

        .header-section-table-notification-draft {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-section-table-notification-draft .comment-header {
            font-weight: bolder;
            font-style: italic;
            color: #a927f9;
        }

        .form-popup {
            width: max-content;
        }

        .faq-body {
            max-height: 70vh;
            overflow: auto;
        }

        .param-added {
            padding: 5px 10px;
            background: rgba(115, 102, 255, 0.75);
            color: #000000;
            cursor: pointer;
            margin: 0px 2px;
            border-radius: 0.5rem;
            border: 0px solid;
            position: relative;
        }

        .param-added .icon-remove {
            display: none;
        }

        .scroll-none::-webkit-scrollbar {
            display: none;
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
                            <tr class="template-box">
                                <th scope="row">Notification For</th>
                                <td>{{ $dataDraft->notification_for }}</td>
                            </tr>

                            <tr class="template-box">
                                <th scope="row">Notification Title</th>
                                <td id="notification-title">{!!  $dataDraft->notification_title  !!}</td>
                            </tr>

                            <tr id="tr-user-line" class="template-box" style="cursor:pointer;">
                                <th scope="row">Line user List will see</th>
                                <td>{{ $dataDraft->line_user }} <i class="fa fa-info-circle" aria-hidden="true"></i></td>
                            </tr>
                            <tr id="tr-user-email" class="template-box" style="cursor:pointer;">
                                <th scope="row">Mail user List will see</th>
                                <td>{{ $dataDraft->mail_user }} <i class="fa fa-info-circle" aria-hidden="true"></i></td>
                            </tr>
                            <tr id="tr-user-sms" class="template-box" style="cursor:pointer;">
                                <th scope="row">SMS User List will see</th>
                                <td>{{ $dataDraft->sms_user }} <i class="fa fa-info-circle" aria-hidden="true"></i></td>
                            </tr>
                            <tr class="template-box">
                                <th scope="row">Created at</th>
                                <td>{{ $dataDraft->created_at }}</td>
                            </tr>
                            <tr class="template-box">
                                <th scope="row">Scheduled at</th>
                                <td>{{ $dataDraft->scheduled_at??"Send Now" }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="section-list-btn">
                            <button type="button" class="btn btn-light" id="btn-cancel-notification-case-draft"
                                    draft_id="{{ $dataDraft->id }}">Cancel
                            </button>
                            <button type="button" class="btn btn-info" id="btn-edit-notification-case-draft"
                                    draft_id="{{ $dataDraft->id }}">Edit
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-send-notification-case-draft"
                                    draft_id="{{ $dataDraft->id }}">Send
                            </button>
                        </div>
                    </div>

                    <div class="col-2 section-preview-notification"
                         style="height: 500px; overflow-y: hidden; box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
                        <style>
                            @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400);

                            .container {
                                width: 400px;
                                padding: 10px;
                            }

                            .message-blue {
                                position: relative;
                                padding: 10px;
                                background-color: #A8DDFD;
                                width: 100%;
                                height: max-content;
                                text-align: left;
                                font: 400 0.9em 'Open Sans', sans-serif;
                                border: 1px solid #97C6E3;
                                border-radius: 0px 20px 20px 20px;
                            }

                            .message-content {
                                padding: 0;
                                margin: 0;
                            }

                        </style>

                        <div class="container scroll-none" style="height: 450px; overflow-y: scroll">
                            <div class="message-blue">
                                <div id="preview-mess-content-notification"
                                     class="message-content">{!! $dataDraft->notification_content !!}</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($dataDraft->notification_for == "user")
        <div class="data-line-table" style="display: none;">
            @if(count($dataDraft->lineUsers) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Nickname</th>
                        <th scope="col">Real name</th>
                        <th scope="col">Line ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dataDraft->lineUsers as $sublistUser)
                        <tr data-id-register=''>
                            <td>{{ $sublistUser->nickname }}</td>
                            <td>{{ $sublistUser->realname }}</td>
                            <td>{{ $sublistUser->lineId }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h6>No Line user</h6>
            @endif
        </div>

        <div class="data-email-table" style="display: none;">
            @if(count($dataDraft->emailUsers) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Nickname</th>
                        <th scope="col">Real name</th>
                        <th scope="col">Email address</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dataDraft->emailUsers as $sublistUser)
                        <tr data-id-register=''>
                            <td>{{ $sublistUser->nickname }}</td>
                            <td>{{ $sublistUser->realname ?? '' }}</td>
                            <td>{{ $sublistUser->emailDecrypted ?? '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h6>No Email user</h6>
            @endif
        </div>

        <div class="data-sms-table" style="display: none;">
            @if(count($dataDraft->smsUsers) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Nickname</th>
                        <th scope="col">Real name</th>
                        <th scope="col">Phone Number</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dataDraft->smsUsers as $sublistUser)
                        <tr data-id-register=''>
                            <td>{{ $sublistUser->nickname }}</td>
                            <td>{{ $sublistUser->realname ?? '' }}</td>
                            <td>{{ $sublistUser->phoneNumberDecrypted ?? '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h6>No SMS user</h6>
            @endif
        </div>
    @elseif($dataDraft->notification_for == "store")
        <div class="data-line-table" style="display: none;">
            @if(count($dataDraft->lineUsers) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Store name</th>
                        <th scope="col">Line ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dataDraft->lineUsers as $sublistUser)
                        <tr data-id-register=''>
                            <td>{{ $sublistUser->store_name }}</td>
                            <td>{{ $sublistUser->lineId }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h6>No Line user</h6>
            @endif
        </div>

        <div class="data-email-table" style="display: none;">
            @if(count($dataDraft->emailUsers) > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Store name</th>
                        <th scope="col">Email address</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dataDraft->emailUsers as $sublistUser)
                        <tr data-id-register=''>
                            <td>{{ $sublistUser->store_name }}</td>
                            <td>{{ $sublistUser->emailDecrypted }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h6>No Email user</h6>
            @endif
        </div>

        <div class="data-sms-table" style="display: none;">
            @if(count($dataDraft->smsUsers) > 0)
                <table class="table">
                    <thead>
                    <tr>

                        <th scope="col">Real name</th>
                        <th scope="col">Phone Number</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dataDraft->smsUsers as $sublistUser)
                        <tr data-id-register=''>
                            <td>{{ $sublistUser->store_name }}</td>
                            <td>{{ $sublistUser->phoneNumberDecrypted }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h6>No SMS user</h6>
            @endif
        </div>
    @endif
@endsection

@section('script')
    <script>
        let btnBackPage = document.querySelector('#btn-back-page');
        btnBackPage.addEventListener('click', (e) => {
            window.location.href = "/admin/notification-list";
        });

        // This function is convert html code to content notification
        function convertHTMLToContentNotification(htmlTagContent) {
            htmlTagContent = htmlTagContent.cloneNode(true)
            const paramAddedS = htmlTagContent.querySelectorAll(".param-added");
            paramAddedS.forEach(paramAdded => {
                paramAdded.querySelector(".icon-remove").remove()
                paramAdded.textContent = paramAdded.textContent.trim();
                paramAdded.outerHTML = `{${paramAdded.textContent}}`
            })

            const paramBr = htmlTagContent.querySelectorAll("br");
            paramBr.forEach(paramBR => {
                paramBR.outerHTML = `{br}`
            })

            return htmlTagContent.textContent
        }

        const btnSend = document.querySelector("#btn-send-notification-case-draft");
        btnSend.addEventListener("click", event => {
            var form = new FormData()
            form.append("notificationContent", convertHTMLToContentNotification(document.querySelector("#preview-mess-content-notification")))
            form.append("notificationTitle", convertHTMLToContentNotification(document.querySelector("#notification-title")))
            form.append("notification_draft_id", event.currentTarget.getAttribute("draft_id"))



            console.log(convertHTMLToContentNotification(document.querySelector("#preview-mess-content-notification")))
            console.log(convertHTMLToContentNotification(document.querySelector("#notification-title")))


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{URL::to("/admin/send-notification")}}',
                method: 'post',
                data: form,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {

                    window.location.href = "/admin/notification-list?messToast=Send Success!";

                },
                error: function () {
                    displayToast('Can not add data!');
                }
            })
        })

        const btnCancel = document.querySelector("#btn-cancel-notification-case-draft");
        btnCancel.addEventListener("click", event => {
            var form = new FormData()
            form.append("notification_draft_id", event.currentTarget.getAttribute("draft_id"))

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{URL::to("/admin/cancel-notification-draft")}}',
                method: 'post',
                data: form,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {

                    window.location.href = "/admin/notification-list?messToast=Cancel Success!";

                },
                error: function () {
                    displayToast('Can not add data!');
                }
            })
        })

        const btnEdit = document.querySelector("#btn-edit-notification-case-draft");
        btnEdit.addEventListener("click", event => {
            location.href = `/admin/update-notification-draft/${btnEdit.getAttribute("draft_id")}/{{$dataDraft->notification_for}}`
        })

    </script>

    <script>
        let parentFormPopup = document.querySelector(".parent-form-popup")
        let closePopup = parentFormPopup.querySelector(".close-popup")


        closePopup.addEventListener("click", eventClose => {
            let tmpParent = eventClose.currentTarget.closest(".parent-form-popup")
            tmpParent.style.display = "none"
            tmpParent.querySelector(".faq-form").innerHTML = ``
        })

        let trUserSms = document.querySelector("#tr-user-sms")
        trUserSms.addEventListener("click", event => {
            let dataSmsTable = document.querySelector(".data-sms-table").cloneNode(true);
            dataSmsTable.style.display = "block"
            parentFormPopup.querySelector(".title-popup").textContent = "SMS user List"
            parentFormPopup.querySelector(".faq-form").appendChild(dataSmsTable)
            parentFormPopup.style.display = "block"
        })

        let trUserLine = document.querySelector("#tr-user-line")
        trUserLine.addEventListener("click", event => {
            let dataLineTable = document.querySelector(".data-line-table").cloneNode(true);
            dataLineTable.style.display = "block"
            parentFormPopup.querySelector(".title-popup").textContent = "Line user List"
            parentFormPopup.querySelector(".faq-form").appendChild(dataLineTable)
            parentFormPopup.style.display = "block"
        })

        let trUserEmail = document.querySelector("#tr-user-email")
        trUserEmail.addEventListener("click", event => {
            let dataEmailTable = document.querySelector(".data-email-table").cloneNode(true);
            dataEmailTable.style.display = "block"
            parentFormPopup.querySelector(".title-popup").textContent = "Email user List"
            parentFormPopup.querySelector(".faq-form").appendChild(dataEmailTable)
            parentFormPopup.style.display = "block"
        })

    </script>

@endsection
