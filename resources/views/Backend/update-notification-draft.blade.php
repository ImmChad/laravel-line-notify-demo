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

        .ipt-text-notification {
            width: 100%;
            height: 100%;
            border-radius: 0.5rem;
            border: 3px solid var(--theme-deafult);
            padding: 10px;
            margin-bottom: 10px;
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
            position: absolute;
            right: -8px;
            top: -8px;
            cursor: pointer;
            border-radius: 0.5rem;
            color: rgba(115, 102, 255, 0.75);
            border: 1px solid rgba(115, 102, 255, 0.75);;
            display: flex;
            background: white;
            width: 20px;
            height: 20px;
            justify-content: center;
            align-items: center;
            font-size: 15px;
            line-height: 0;
            padding: 0;
            z-index: 1;
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none; /* IE 10 and IE 11 */
            user-select: none; /* Standard syntax */
        }

        .section-params {
            position: relative;
            display: flex;
            justify-content: start;
        }

        .name-param {
            padding: 5px 10px;
            background: var(--theme-deafult);
            color: white;
            cursor: pointer;
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

                    <div placeholder="Please Notification title"
                         required=""
                         minlength="10"
                         maxlength="255"
                         contenteditable="true"
                         class="ipt-text-notification"
                         id="ipt-title-notification"
                        >
                        {!! $detailTemplate->template_content !!}
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
                                    {!! $detailTemplate->template_content !!}
                                @else
                                    Enter content, please!
                                @endif
                            </div>

                        </div>

                    </div>


                    <div class="section-params" style="padding: 1rem; width: 100%; display: flex; flex-wrap: wrap; justify-content: center; align-items: center;">

                        @if(isset($listParam))
                            @foreach($listParam as $subListParam)
                                <div class="name-param" style=" margin: 0 0.2rem;"><button style="padding: 0px;  background: none; color: white;" class="btn param-added">{{ $subListParam->value }}</button></div>
                            @endforeach
                        @else
                            <div>Please choose send for user or store.</div>
                        @endif

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
                                        <option areaId="0" selected>Null</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="part-select-params " style="width: 100%;">
                                    <select class="form-select industry-select" aria-label="Default select example">
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
                                    <select class="form-select send-for-select" aria-label="Default select example"
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
                                    <input  class="form-check-input radio-send-with-schedule" type="radio" name="radio1"
                                           id="radio1"
                                            value="scheduled">
                                    <label for="radio1" class="form-check-label mb-0" style="margin: 0;">Send with
                                        schedule</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-check form-check-inline radio radio-dark btn btn-outline-primary btn-tick-send">
                                    <input checked class="form-check-input radio-send-now" type="radio" name="radio1"
                                           id="radio2"
                                           value="option1" >
                                    <label for="radio2" class="form-check-label mb-0" style="margin: 0;">Send
                                        now</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="width: 100%; margin-top: 15px;">
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <input style="display: none" class="form-control digits ipt-time-schedule" id="example-datetime-local-input" type="datetime-local"  data-bs-original-title="" title="">
                            </div>
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>--}}

@endsection


@section('script')
    <script>
        const iptTimeScheduled= document.querySelector(".ipt-time-schedule")
        const radioSchedule = document.querySelector(".radio-send-with-schedule")
        radioSchedule.addEventListener("change",event =>{
            console.log(event.currentTarget.checked)

            if(event.currentTarget.checked)
            {
                iptTimeScheduled.style.display = "block"
            }
        })
        const radioNow = document.querySelector(".radio-send-now")
        radioNow.addEventListener("change",event => {
            if(event.currentTarget.checked = "scheduled")
            {
                iptTimeScheduled.style.display = "none"
            }
        })
    </script>

    <script>
        // remove param in input content
        const edt = document.querySelector("#ipt-content-notification")
        const itn = document.querySelector("#ipt-title-notification")

        let btnRemoves = edt.querySelectorAll(".param-added .icon-remove")
        btnRemoves.forEach(btnRemove => {
            btnRemove.addEventListener("click", event => {
                event.currentTarget.closest(".param-added").remove()
            })
        })

        // creat param in content
        const nameParams = document.querySelectorAll(".name-param")
        nameParams.forEach(nameParam => {
            nameParam.addEventListener("click", event => {

                const range = window.getSelection().getRangeAt(0);
                const btn = document.createElement('button');
                const icRemove = document.createElement('i')
                icRemove.classList.add("icon-remove")
                icRemove.textContent = "-"

                btn.classList.add("param-added")
                btn.textContent = event.currentTarget.textContent;
                btn.contentEditable = false
                btn.appendChild(icRemove);

                if(
                    range.commonAncestorContainer.parentNode == edt
                    || range.commonAncestorContainer == edt
                    || range.commonAncestorContainer.parentNode == itn
                    || range.commonAncestorContainer == itn
                    || edt.contains(range.commonAncestorContainer.parentNode)
                    || edt.contains(range.commonAncestorContainer)
                    || itn.contains(range.commonAncestorContainer.parentNode)
                    || itn.contains(range.commonAncestorContainer)
                )
                {
                    range.insertNode(btn);
                }

                let btnRemoves = document.querySelectorAll(".param-added .icon-remove")
                btnRemoves.forEach(btnRemove => {
                    btnRemove.addEventListener("click", event => {
                        event.currentTarget.closest(".param-added").remove()
                    })
                })
            })
        })
    </script>

    <script>
        // choose type function
        let notificationTypeSelect = document.querySelector('.notification-type-select');
        notificationTypeSelect.addEventListener('change', function (ev) {
            let uri = notificationTypeSelect.options[notificationTypeSelect.selectedIndex].getAttribute('uri');

            if (uri != "null") {
                window.location.href = "/admin/update-notification-draft/{{$dataDraft->id}}/" + uri + "/"
            }

        });

        // choose template function
        let templateSelect = document.querySelector('.template-select');
        templateSelect.addEventListener('change', (e) => {
            let templateId = templateSelect.options[templateSelect.selectedIndex].getAttribute('templateId');

            if (templateId != 'null') {
                let notificationSender = templateSelect.options[templateSelect.selectedIndex].getAttribute('notificationSender');
                window.location.href = "/admin/update-notification-draft/{{$dataDraft->id}}/" + notificationSender + "/" + templateId;
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
            console.log(data);
            let areaSelect = document.querySelector('.area-select');
            areaSelect.innerHTML = `
                <option areaId="0">Please select area</option>
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

        // back to /admin/notification-list
        let btnBackPage = document.querySelector('#btn-back-page');
        btnBackPage.addEventListener('click', (e) => {
            window.location.href = "/admin/notification-list";
        });

        // send Notification
        let btnSend = document.querySelector('.btn-send')


        btnSend.addEventListener('click', () => {

            let notificationTypeSelect = document.querySelector('.notification-type-select');
            let sendForSelect = document.querySelector('.send-for-select')


            let announceFor = notificationTypeSelect.options[notificationTypeSelect.selectedIndex].getAttribute('uri')
            let announceTitle = document.querySelector('#ipt-title-notification').innerHTML
            let announceContent = document.querySelector('#ipt-content-notification').innerHTML

            let announceTypeFor = sendForSelect.options[sendForSelect.selectedIndex].getAttribute('value')
            let created_at = $('#example-datetime-local-input').val();
            let diffInSeconds = "";


            if(announceFor == "null")
            {
                displayToast('Please select type')
            }
            else if(announceTitle.trim() == "")
            {
                displayToast('Please enter full announce title')
            }
            else if(announceContent.trim() == "")
            {
                displayToast('Please enter full announce content')
            }
            else
            {

                let getSchedule =  document.querySelector('.radio-send-with-schedule:checked')
                if(getSchedule != null)
                {
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

                    let [dateChoose, timeChoose] = newDate.split(' ');
                    let [hourChoose, minuteChoose, secondChoose] = timeChoose.split(':');
                    let newHour = hourChoose.replace('24', '00');

                    newDate = dateChoose + " " + newHour + ":" + minuteChoose + ":" + secondChoose;

                    if(created_at.trim() != "") {
                        const date1 = new Date(newDate);
                        const date2 = new Date(created_at);
                        diffInSeconds = (date2 - date1) / 1000;
                    } else {
                        diffInSeconds = 0;
                    }

                }
                else
                {
                    diffInSeconds = 0;
                }

                if(diffInSeconds < 0)
                {
                    displayToast("Can't enter this date in the past to set the timer!")
                }
                else {
                    if(announceTypeFor == 1)
                    {
                        let areaId = "0"
                        let industryId = "0"

                        var form  = new FormData();
                        form.append('message', announceContent);
                        form.append('title', announceTitle);
                        form.append('announceFor', announceFor);
                        form.append('areaId', areaId);
                        form.append('industryId', industryId);
                        form.append('delayTime', diffInSeconds);
                        form.append('announceTypeFor', announceTypeFor);
                        form.append('type_notification', "2");
                        form.append('notification_draft_id', '{{$dataDraft->id}}');


                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{{URL::to("/admin/update-notification-draft")}}',
                            method: 'post',
                            data: form,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function (data) {

                                window.location.href = "/admin/send-notification-view/3?messToast=Send Success!";

                            },
                            error: function () {
                                displayToast('Can not add data!');
                            }
                        })
                    }
                    else if (announceTypeFor == 2)
                    {
                        let areaSelect = document.querySelector('.area-select')
                        let industrySelect = document.querySelector('.industry-select')

                        let areaId = areaSelect.options[areaSelect.selectedIndex].getAttribute('areaid')
                        let industryId = industrySelect.options[industrySelect.selectedIndex].getAttribute('industryid')


                        var form  = new FormData();
                        form.append('message', announceContent);
                        form.append('title', announceTitle);
                        form.append('announceFor', announceFor);
                        form.append('areaId', areaId);
                        form.append('industryId', industryId);
                        form.append('delayTime', diffInSeconds);
                        form.append('announceTypeFor', announceTypeFor);
                        form.append('type_notification', "2");
                        form.append('notification_draft_id', '{{$dataDraft->id}}');


                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{{URL::to("/admin/update-notification-draft")}}',
                            method: 'post',
                            data: form,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function (data) {

                               window.location.href = "/admin/send-notification-view/3?messToast=Send Success!";

                            },
                            error: function () {
                                displayToast('Can not add data!');
                            }
                        })



                    }
                    else {
                        displayToast('Please select send for')
                    }
                }

            }

        })

    </script>

@endsection




































