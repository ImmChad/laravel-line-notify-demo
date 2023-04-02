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
            padding-top: 60px;
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

                    <input style="display: none;" id="getDraftId" value="{{ $notification_draft_id }}">
                    <input style="display: none;" id="getNotificationId" value="{{ $notificationId }}">


                    <div class="section-select-type">
                        <select class="form-select notification-type-select" aria-label="Default select example">
                            @if($dataNotification->notification_for == "store")
                                <option value="2" uri="store" selected>Store</option>
                            @elseif($dataNotification->notification_for == "user")
                                <option value="1" uri="user" selected>User</option>
                            @endif
                        </select>
                    </div>

                    <div class="field-ipt-text field-title-notification">
                        <div
                            placeholder="Please Notification title"
                            required=""
                            minlength="10"
                            maxlength="255"
                            contenteditable="true"
                            class="ipt-text-notification"
                            id="ipt-title-notification">
                            @if(isset($detailTemplate))
                                {!! $detailTemplate->template_title !!}
                            @else
                                {!! $dataNotification->notification_title !!}
                            @endif
                        </div>
                    </div>

                    <div class="section-template">
                        <div class="part-preview-template">
                            <div class="ipt-content-template" data-cke-editable="false" contenteditable="true"
                                 id="ipt-content-notification">
                                @if (isset($detailTemplate ) && $detailTemplate != null)
                                    {!! $detailTemplate->template_content !!}
                                @else
                                    {!! $dataNotification->notification_content !!}
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

                                        @if(isset($regionId))
                                            @foreach($dataRegion as $subDataRegion)
                                                @if($regionId == $subDataRegion->id)
                                                    <option regionId="0">Please select region</option>
                                                    <option
                                                        regionId="{{ $subDataRegion->id }}" selected>{{ $subDataRegion->region_name }}
                                                        - {{ $subDataRegion->region_name_jp }}</option>
                                                @else
                                                    <option
                                                        regionId="{{ $subDataRegion->id }}">{{ $subDataRegion->region_name }}
                                                        - {{ $subDataRegion->region_name_jp }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option regionId="0" selected>Please select region</option>
                                            @foreach($dataRegion as $subDataRegion)
                                                <option
                                                    regionId="{{ $subDataRegion->id }}" >{{ $subDataRegion->region_name }}
                                                    - {{ $subDataRegion->region_name_jp }}</option>
                                            @endforeach
                                        @endif


                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="part-select-params " style="width: 100%;">
                                    <select class="form-select area-select" aria-label="Default select example">
                                        @if($dataNotification->area_id != 0)
                                            <option areaId="0">Please select area</option>
                                            @foreach($dataArea as $subDataArea)
                                                @if($dataNotification->area_id == $subDataArea->id)
                                                    <option
                                                        areaId="{{ $subDataArea->id }}" selected>{{ $subDataArea->area_name }}</option>
                                                @else
                                                    <option
                                                        areaId="{{ $subDataArea->id }}">{{ $subDataArea->area_name }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option areaId="0" selected>Null</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="part-select-params " style="width: 100%;">
                                    <select class="form-select industry-select" aria-label="Default select example">
                                        @if($dataNotification->industry_id != 0)
                                            <option industryId="0" selected>Please select industry</option>
                                            @foreach($dataIndustry as $subDataIndustry)
                                                @if($dataNotification->industry_id == $subDataIndustry->id)
                                                    <option
                                                        industryId="{{ $subDataIndustry->id }}" selected>{{ $subDataIndustry->industry_name }}
                                                        - {{ $subDataIndustry->industry_name_jp }}</option>
                                                @else
                                                    <option
                                                        industryId="{{ $subDataIndustry->id }}">{{ $subDataIndustry->industry_name }}
                                                        - {{ $subDataIndustry->industry_name_jp }}</option>
                                                @endif

                                            @endforeach
                                        @else
                                            <option industryId="0" selected>Please select industry</option>
                                            @foreach($dataIndustry as $subDataIndustry)
                                                <option
                                                    industryId="{{ $subDataIndustry->id }}">{{ $subDataIndustry->industry_name }}
                                                    - {{ $subDataIndustry->industry_name_jp }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="part-select-params" style="width: 100%;">
                                    <select class="form-select send-for-select" aria-label="Default select example"
                                            style="width: 100%;">

                                        @if($dataNotification->notification_for == "user")
                                            <option value="1" >All user</option>
                                            <option value="2" {{ $dataNotification->area_id > 0 || $dataNotification->industry_id > 0 ? "selected" : ""  }}>User narrow down selection from area</option>
                                        @elseif($dataNotification->notification_for == "store")
                                            <option value="1">All store</option>
                                            <option value="2" {{ $dataNotification->area_id > 0 || $dataNotification->industry_id > 0 ? "selected" : ""  }}>Store narrow down selection from area</option>
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
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary btn-send">
                                    UPDATE
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
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
        let uri = notificationTypeSelect.options[notificationTypeSelect.selectedIndex].getAttribute('uri');

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

        // choose area from region
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


            let getDraftId = document.querySelector('#getDraftId').value
            let getNotificationId = document.querySelector('#getNotificationId').value


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

                if(announceTypeFor == 1)
                {
                    let areaId = "0"
                    let industryId = "0"

                    var form  = new FormData();
                    form.append('getDraftId', getDraftId);
                    form.append('getNotificationId', getNotificationId);
                    form.append('message', announceContent);
                    form.append('title', announceTitle);
                    form.append('notificationTitle', convertHTMLToContentNotification(document.querySelector("#ipt-title-notification")))
                    form.append('notificationContent',  convertHTMLToContentNotification(document.querySelector("#ipt-content-notification")));
                    form.append('areaId', areaId);
                    form.append('industryId', industryId);
                    form.append('type_notification', "2");


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{URL::to("/admin/update-mess")}}',
                        method: 'post',
                        data: form,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (data) {
                            window.location.href = "/admin/notification-list";
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
                    form.append('getDraftId', getDraftId);
                    form.append('getNotificationId', getNotificationId);
                    form.append('message', announceContent);
                    form.append('title', announceTitle);
                    form.append('notificationTitle', convertHTMLToContentNotification(document.querySelector("#ipt-title-notification")))
                    form.append('notificationContent',  convertHTMLToContentNotification(document.querySelector("#ipt-content-notification")));
                    form.append('announceFor', announceFor);
                    form.append('areaId', areaId);
                    form.append('industryId', industryId);
                    form.append('announceTypeFor', announceTypeFor);
                    form.append('type_notification', "2");


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{URL::to("/admin/update-mess")}}',
                        method: 'post',
                        data: form,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (data) {
                            window.location.href = "/admin/notification-list";
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

        })


        // This function is convert html code to content notification
        function convertHTMLToContentNotification(htmlTagContent)
        {
            htmlTagContent = htmlTagContent.cloneNode(true)
            const paramAddedS =  htmlTagContent.querySelectorAll(".param-added");
            paramAddedS.forEach(paramAdded=>{
                paramAdded.querySelector(".icon-remove").remove()
                paramAdded.outerHTML = `{${paramAdded.textContent}}`
            })

            const paramBr =  htmlTagContent.querySelectorAll("br");
            paramBr.forEach(paramBR=>{
                paramBR.outerHTML = `{br}`
            })

            return htmlTagContent.textContent
        }

    </script>

@endsection





