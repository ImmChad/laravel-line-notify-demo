@extends('admin.backend-view')
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
                            @if($dataTemplate['template_type'] == 'user')
                                <option value="user">User</option>
                            @else
                                <option value="store">Store</option>
                            @endif
                        </select>
                    </div>
                    <div class="section-template">
                        <div class="part-input-text-template">
                            <div class="part-input-text-template">
                                <div class="field-ipt-text field-title-notification">
                                    <input
                                            placeholder="Please input name"
                                            required
                                            minlength="10"
                                            maxlength="225"
                                            contenteditable="true"
                                            class="ipt-text-notification"
                                            id="ipt-name-notification"
                                            value="{{ $dataTemplate['template_name'] }}">

                                </div>

                                <div class="field-ipt-text field-title-notification">
                                    <div
                                            placeholder="Please input title"
                                            required
                                            minlength="10"
                                            maxlength="225"
                                            contenteditable="true"
                                            class="ipt-text-notification"
                                            id="ipt-title-notification">{!! $dataTemplate['template_title'] !!}</div>
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
                                    <div class="name-param">
                                        <button style="padding: 0px;  background: none; color: white;"
                                                class="btn param-added">{{ $subListParam->value }}</button>
                                    </div>
                                @endforeach
                            @else
                                <div>Please choose send for user or store.</div>
                            @endif

                        </div>
                        <div class="section-option-btn">
                            <div data-template-id="{{$dataTemplate['id']}}" id="btn-save-new-template"
                                 class="btn btn-primary btn-opt-add-template">
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

                // button back
                let returnNotificationList = document.querySelector('#btn-back-page');
                returnNotificationList.addEventListener('click', (e) => {
                    window.location.href = "/admin/template-management";
                });

                const nameParams = document.querySelectorAll(".name-param")
                const edt = document.querySelector("#ipt-content-notification")
                const itn = document.querySelector("#ipt-title-notification")
                let sendTypeSelect = document.querySelector('.send-type-select')

                // button remove param
                let btnRemoves = document.querySelectorAll(".param-added .icon-remove")
                btnRemoves.forEach(btnRemove => {
                    btnRemove.addEventListener("click", event => {
                        event.currentTarget.closest(".param-added").remove()
                    })
                })

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

                        if (
                            range.commonAncestorContainer.parentNode == edt
                            || range.commonAncestorContainer == edt
                            || range.commonAncestorContainer.parentNode == itn
                            || range.commonAncestorContainer == itn
                            || edt.contains(range.commonAncestorContainer.parentNode)
                            || edt.contains(range.commonAncestorContainer)
                            || itn.contains(range.commonAncestorContainer.parentNode)
                            || itn.contains(range.commonAncestorContainer)
                        ) {
                            range.insertNode(btn);
                        }
                        console.log(range.commonAncestorContainer)
                        let btnRemoves = document.querySelectorAll(".param-added .icon-remove")
                        btnRemoves.forEach(btnRemove => {
                            btnRemove.addEventListener("click", event => {
                                event.currentTarget.closest(".param-added").remove()
                            })
                        })
                    })
                })


                // button update
                let btnSaveNewTemplate = document.querySelector('#btn-save-new-template')
                btnSaveNewTemplate.addEventListener('click', (event) => {

                    let templateType = sendTypeSelect.options[sendTypeSelect.selectedIndex].getAttribute('value')
                    let templateName = document.querySelector('#ipt-name-notification').value
                    let templateTitle = document.querySelector('#ipt-title-notification').innerHTML
                    let templateContent = document.querySelector('#ipt-content-notification').innerHTML


                    if (templateType == 0) {
                        displayToast('Please select type')
                    } else if (templateName.trim() == "") {
                        displayToast('Please enter template name')
                    } else if (templateTitle.trim() == "") {
                        displayToast('Please enter full template title')
                    } else if (templateContent.trim() == "") {
                        displayToast('Please enter full template content')
                    } else {
                        let form = new FormData()
                        form.append('templateType', templateType)
                        form.append('templateName', templateName)
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
@endsection




































