@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>

        .content-send-notification {
            padding: 20px;
        }

        .section-select-type {
            margin-left: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
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
    </style>


    <div class="row"
         style="display: flex; justify-content: center; align-items: center; padding: 0rem 0rem !important; margin: 0px !important;">
        <div class="col" style="padding: 0px;">
            <div class="card height-equal">
                <div class="content-send-notification">
                    <div id="btn-back-page">Back</div>
                    <div class="section-select-type">
                        <select class="form-select notification-type-select" aria-label="Default select example">

                            @if(isset($notificationSender))

                                @if($notificationSender == "store")
                                    <option value="0" uri="null">Please select type</option>
                                    <option value="1" uri="user">User</option>
                                    <option value="2" uri="store" selected>Store</option>
                                @else
                                    <option value="0" uri="null">Please select type</option>
                                    <option value="1" uri="user" selected>User</option>
                                    <option value="2" uri="store">Store</option>
                                @endif

                            @else
                                <option value="0" uri="null" selected>Please select type</option>
                                <option value="1" uri="user">User</option>
                                <option value="2" uri="store">Store</option>
                            @endif

                        </select>
                    </div>
                    <div class="section-template">
                        <div class="part-select-template">
                            <select class="form-select template-select" aria-label="Default select example">

                                @if(isset($notificationSender))

                                    @if(isset($detailTemplate))

                                        <option templateId="null">Please select type</option>
                                        @foreach($dataTemplate as $subDataTemplate)

                                            @if($detailTemplate->id == $subDataTemplate->id)
                                                <option notificationSender="{{ $notificationSender }}"
                                                        templateId="{{ $subDataTemplate->id }}"
                                                        templateName="{{ $subDataTemplate->template_name }}"
                                                        selected>{{ $subDataTemplate->template_name }}</option>
                                            @else
                                                <option notificationSender="{{ $notificationSender }}"
                                                        templateId="{{ $subDataTemplate->id }}"
                                                        templateName="{{ $subDataTemplate->template_name }}">{{ $subDataTemplate->template_name }}</option>
                                            @endif

                                        @endforeach

                                    @else

                                        <option templateId="null">Please select type</option>
                                        @foreach($dataTemplate as $subDataTemplate)
                                            <option notificationSender="{{ $notificationSender }}"
                                                    templateId="{{ $subDataTemplate->id }}"
                                                    templateName="{{ $subDataTemplate->template_name }}">{{ $subDataTemplate->template_name }}</option>
                                        @endforeach

                                    @endif

                                @else
                                    <option value="0" uri="null" selected>No template</option>
                                @endif

                            </select>
                        </div>
                        <div class="part-preview-template">
                            <div class="ipt-content-template" data-cke-editable="false" contenteditable="true"
                                 id="ipt-content-notification">
                                @if (isset($detailTemplate ) && $detailTemplate != null)
                                    {{ $detailTemplate->template_title }} - {!! $detailTemplate->template_content !!}
                                @else
                                    Enter content, please!
                                @endif
                            </div>

                        </div>

                    </div>


                    <div class="section-option-others">
                        <div class="row" style="width: 100%;">
                            <div class="col-md-3">
                                <div class="part-select-params" style="width: 100%;">
                                    <select class="form-select region-select" aria-label="Default select example">

                                        @if(isset($notificationSender))
                                            <option regionId="0" selected>Please select region</option>
                                            @foreach($dataRegion as $subDataRegion)
                                                <option
                                                    regionId="{{ $subDataRegion->id }}">{{ $subDataRegion->region_name }}
                                                    - {{ $subDataRegion->region_name_jp }}</option>
                                            @endforeach
                                        @else
                                            <option regionId="0" selected>Null</option>
                                        @endif


                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="part-select-params " style="width: 100%;">
                                    <select class="form-select area-select" aria-label="Default select example">
                                        <option value="0" selected>Null</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="part-select-params industry-select" style="width: 100%;">
                                    <select class="form-select" aria-label="Default select example">
                                        @if(isset($notificationSender))
                                            <option industryId="0" selected>Please select industry</option>
                                            @foreach($dataIndustry as $subDataIndustry)
                                                <option
                                                    industryId="{{ $subDataIndustry->id }}">{{ $subDataIndustry->industry_name }}
                                                    - {{ $subDataIndustry->industry_name_jp }}</option>
                                            @endforeach
                                        @else
                                            <option industryId="0" selected>Null</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="part-select-params" style="width: 100%;">
                                    <select class="form-select" aria-label="Default select example"
                                            style="width: 100%;">

                                        @if(isset($notificationSender) && $notificationSender == "user")
                                            <option value="0" selected>Send for</option>
                                            <option value="1">All user</option>
                                            <option value="2">User narrow down selection from area</option>
                                        @elseif(isset($notificationSender) && $notificationSender == "store")
                                            <option value="0" selected>Send for</option>
                                            <option value="1">All store</option>
                                            <option value="2">Store narrow down selection from area</option>
                                        @else
                                            <option value="0" selected>Null</option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="width: 100%; margin-top: 15px;">
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div
                                    class="form-check form-check-inline radio radio-dark btn btn-outline-primary btn-tick-send">
                                    <input class="form-check-input radio-send-with-schedule" type="radio" name="radio1"
                                           value="option1">
                                    <label class="form-check-label mb-0" style="margin: 0;">Send with
                                        schedule</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-check form-check-inline radio radio-dark btn btn-outline-primary btn-tick-send">
                                    <input class="form-check-input radio-send-now" type="radio" name="radio1"
                                           value="option1" >
                                    <label class="form-check-label mb-0" style="margin: 0;">Send
                                        now</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="width: 100%; margin-top: 15px;">
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary btn-send">
                                    Send
                                </button>
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
        // choose type function
        let notificationTypeSelect = document.querySelector('.notification-type-select');
        notificationTypeSelect.addEventListener('change', function (ev) {
            let uri = notificationTypeSelect.options[notificationTypeSelect.selectedIndex].getAttribute('uri');

            if (uri != "null") {
                window.location.href = "/admin/send-notification-view/3/" + uri + "/"
            }

        });

        // choose template function
        let templateSelect = document.querySelector('.template-select');
        templateSelect.addEventListener('change', (e) => {
            let templateId = templateSelect.options[templateSelect.selectedIndex].getAttribute('templateId');

            if (templateId != 'null') {
                let notificationSender = templateSelect.options[templateSelect.selectedIndex].getAttribute('notificationSender');
                window.location.href = "/admin/send-notification-view/3/" + notificationSender + "/" + templateId;
            }

        })

        // get list area from region function
        let regionSelect = document.querySelector('.region-select');
        regionSelect.addEventListener('change', () => {

            let regionId = regionSelect.options[regionSelect.selectedIndex].getAttribute('regionId');

            if (regionId != 0) {
                console.log(regionId)
                let form = new FormData()
                form.append('regionId', regionId)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{URL::to("/admin/get-area-from-region-id/")}}',
                    method: 'post',
                    data: form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (data) {
                        chooseArea(data);
                    },
                    error: function () {
                        displayToast('Can not add data!');
                    }
                });
            }

        })

        function chooseArea(data) {
            let areaSelect = document.querySelector('.area-select');
            areaSelect.innerHTML = `
                <option areaId="0">Please select area</option
                ${data.map((el, index) => {
                if (data.length != 0) {
                    return `<option areaId="${el.id}">${el.area_name}</option>`
                } else {
                    return `<option areaId="0">No available</option>`
                }
            })
                .join("")}
            `
        }

        //






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




































