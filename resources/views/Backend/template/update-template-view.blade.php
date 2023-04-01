@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .content-send-notification {
            position: relative;
            padding: 20px;
        }

        .section-select-type {
            margin-left: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
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

        .section-select-type select {
            width: max-content;
        }

        .section-params {
            position: relative;
            display: flex;
            justify-content: start;
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

        .section-select-type .dropdown-toggle {
            width: 100%;
            margin-right: 20px;
        }

        .part-input-text-template {
            width: 100%;
            height: 100%;
            padding: 30px;
        }

        .field-ipt-text {
            margin-bottom: 10px;
        }

        .ipt-text-notification {
            width: 100%;

        }

        .field-ipt-text .ipt-text-notification {
            width: 100%;
            height: 100%;
            border-radius: 0.5rem;
            border: 3px solid var(--theme-deafult);
            padding: 10px;
        }

        .field-content-notification #ipt-content-notification {
            padding: 30px;
            min-height: 300px;
            resize: none;
            caret-color: var(--theme-deafult)
        }

        .section-option-btn {
            margin: 10px 0px;
            display: flex;
            align-items: center;
            justify-content: end;
        }

        .btn-opt-add-template {
            margin-right: 20px;
            margin-bottom: 20px;
            min-width: 180px;
        }

        #btn-new-param {
            position: absolute;
            right: 0;
            bottom: 0;
            cursor: pointer;
            border-radius: 10px;
            padding: 4px 10px;
            background: rgba(115, 102, 255, 0.08);
            color: #7366ff;
            display: flex;
        }

        .name-param {
            padding: 5px 10px;
            background: var(--theme-deafult);
            color: white;
            cursor: pointer;
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

        .name-param + .name-param {
            margin-left: 10px;
        }

        [placeholder]:empty::before {
            content: attr(placeholder);
            color: #555;
        }

        [placeholder]:empty:focus::before {
            content: "";
        }
    </style>

    <div class="row"
         style="display: flex; justify-content: center; align-items: center; padding: 0rem 0rem !important; margin: 0px !important;">
        <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 box-col-12">
            <div class="card height-equal">
                <div class="content-send-notification">
                    <div id="btn-back-page">Back</div>
                    <div class="section-select-type ">
                        <select class="form-select send-type-select" aria-label="Default select example">
                                @if(isset($_REQUEST['templateType']))
                                <option value="0">Please select type</option>
                                <option value="user" {{$_REQUEST['templateType'] == 'user' ? 'selected' : '' }}>User</option>
                                <option value="store" {{$_REQUEST['templateType'] == 'store' ?'selected' : '' }}>Store</option>
                                @else
                                <option value="0">Please select type</option>
                                <option value="user" {{$dataTemplate['template_type'] == 'user' ? 'selected' : '' }}>User</option>
                                <option value="store" {{$dataTemplate['template_type'] == 'store' ?'selected' : '' }}>Store</option>
                                @endif
                        </select>
                    </div>
                    <div class="section-template">
                        <div class="part-input-text-template">
                            <div class="part-input-text-template">
                                <div class="field-ipt-text field-title-notification">
                                    <input
                                        placeholder="Please input title"
                                        required
                                        minlength="10"
                                        maxlength="225"
                                        class="ipt-text-notification"
                                        id="ipt-title-notification"
                                        value="{{$dataTemplate['template_title']}}"
                                    >
                                </div>
                                <div class="field-ipt-text field-content-notification">
                                    <div
                                        contenteditable="true"
                                        placeholder="Please input content"
                                        required
                                        minlength="100"
                                        maxlength="200"
                                        class="ipt-text-notification"
                                        id="ipt-content-notification">
                                        @if(!isset($_REQUEST['templateType']) || $_REQUEST['templateType'] == $dataTemplate['template_type'])
                                            {!! $dataTemplate['template_content'] !!}
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="section-params">

                            @if(isset($listParam))
                                @foreach($listParam as $subListParam)
                                    <div class="name-param">{{ $subListParam->value }}</div>
                                @endforeach
                            @else
                                <div>Please choose send for user or store.</div>
                            @endif

                        </div>
                        <div class="section-option-btn">
                            <div data-template-id="{{$dataTemplate['id']}}" id="btn-save-new-template" class="btn btn-primary btn-opt-add-template">
                                Save
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection


        @section('script')
            <script>

                function getCaretPosition(editableDiv) {
                    var caretPos = 0,
                        sel, range;
                    if (window.getSelection) {
                        sel = window.getSelection();
                        if (sel.rangeCount) {
                            range = sel.getRangeAt(0);
                            if (range.commonAncestorContainer.parentNode == editableDiv || range.commonAncestorContainer == editableDiv) {
                                caretPos = range.endOffset;
                            }
                        }
                    } else if (document.selection && document.selection.createRange) {
                        range = document.selection.createRange();
                        if (range.commonAncestorContainer.parentNode == editableDiv || range.commonAncestorContainer == editableDiv) {
                            var tempEl = document.createElement("span");
                            editableDiv.insertBefore(tempEl, editableDiv.firstChild);
                            var tempRange = range.duplicate();
                            tempRange.moveToElementText(tempEl);
                            tempRange.setEndPoint("EndToEnd", range);
                            caretPos = tempRange.text.length;
                        }
                    }
                    return caretPos;
                }

                const nameParams = document.querySelectorAll(".name-param")
                const edt = document.querySelector("#ipt-content-notification")

                let btnRemoves = edt.querySelectorAll(".param-added .icon-remove")
                btnRemoves.forEach(btnRemove => {
                    btnRemove.addEventListener("click", event => {
                        event.currentTarget.closest(".param-added").remove()
                    })
                })

                let startPos = 0;
                edt.addEventListener('blur', event => {
                    for (var i = 0; i < getSelection().rangeCount; i++) {
                        console.log(getSelection().getRangeAt(i))
                    }
                    startPos = getCaretPosition(event.currentTarget);
                    console.log(startPos)
                })

                nameParams.forEach(nameParam => {
                    nameParam.addEventListener("click", event => {
                        // edt.focus();
                        // edt.setSelectionRange(startPos, startPos);
                        const range = window.getSelection().getRangeAt(0);
                        const btn = document.createElement('button');
                        const icRemove = document.createElement('i')
                        icRemove.classList.add("icon-remove")
                        icRemove.textContent = "-"

                        btn.classList.add("param-added")
                        btn.textContent = event.currentTarget.textContent;
                        btn.contentEditable = false
                        btn.appendChild(icRemove);
                        edt.innerHTML = edt.innerHTML.trim().replace("\n") + btn.outerHTML
                        let btnRemoves = edt.querySelectorAll(".param-added .icon-remove")
                        btnRemoves.forEach(btnRemove => {
                            btnRemove.addEventListener("click", event => {
                                event.currentTarget.closest(".param-added").remove()
                            })
                        })

                    })
                })

                // navigation send type for add template
                let sendTypeSelect = document.querySelector('.send-type-select')
                sendTypeSelect.addEventListener('change', () => {
                    let templateType = sendTypeSelect.options[sendTypeSelect.selectedIndex].getAttribute('value')
                    if(templateType != 0)
                    {
                        window.location.href = '/admin/update-template-view/{{$dataTemplate['id']}}?templateType=' + templateType;
                    }
                })

                let btnSaveNewTemplate = document.querySelector('#btn-save-new-template')
                btnSaveNewTemplate.addEventListener('click', (event) => {

                    let templateType = sendTypeSelect.options[sendTypeSelect.selectedIndex].getAttribute('value')
                    let templateTitle = document.querySelector('#ipt-title-notification').value
                    let templateContent = document.querySelector('#ipt-content-notification').innerHTML



                    if(templateType == 0)
                    {
                        displayToast('Please select type')
                    }
                    else if(templateTitle.trim() == "")
                    {
                        displayToast('Please enter full template title')
                    }
                    else if(templateContent.trim() == "")
                    {
                        displayToast('Please enter full template content')
                    } else
                    {
                        let form = new FormData()
                        form.append('templateType', templateType)
                        form.append('templateTitle', templateTitle)
                        form.append('templateContent', templateContent)
                        form.append('id', event.currentTarget.getAttribute("data-template-id"))


                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{{URL::to("/admin/update-template")}}',
                            method: 'post',
                            data: form,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function (data) {
                                document.querySelector('#ipt-title-notification').value = ""
                                document.querySelector('#ipt-content-notification').innerHTML = ""
                                location.href = "/admin/template-management";
                                displayToast('Success!')
                            },
                            error: function () {
                                displayToast('Can not add data!');
                            }
                        });
                    }

                })

            </script>

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


                let returnNotificationList = document.querySelector('#btn-back-page');
                returnNotificationList.addEventListener('click', (e) => {
                    window.location.href = "/admin/template-management";
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
@endsection




































