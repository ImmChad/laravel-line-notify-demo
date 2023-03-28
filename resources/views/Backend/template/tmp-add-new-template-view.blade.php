@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins:after
        {
            height: 0px;
        }
        .content-send-notification
        {
            position: relative;
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
            border-radius: 10px;
            padding: 10px;
            background: rgba(115, 102, 255, 0.08);
            color: #7366ff;

        }
        .section-select-type select
        {
            width: max-content;
        }
        .section-params
        {
            position: relative;
            display: flex;
            justify-content: space-between;
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
        .section-select-type .dropdown-toggle
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
        .field-ipt-text .ipt-text-notification
        {
            width: 100%;
            height: 100%;
            border-radius: 0.5rem;
            border: 3px solid var(--theme-deafult);
            padding: 10px;
        }
        .field-content-notification #ipt-content-notification
        {
            padding: 30px;
            min-height: 300px;
            resize: none;

        }
        .section-option-btn
        {
            margin: 10px 0px;
            display: flex;
            align-items: center;
            justify-content: end;
        }
        .btn-opt-add-template
        {
            margin-right: 20px;
            margin-bottom: 20px;
            min-width: 180px;
        }
        #btn-new-param
        {
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
                        <div class="part-input-text-template">
                            <div class="field-ipt-text field-title-notification">
                                <input
                                    placeholder="Please input title"
                                    required
                                    minlength="5"
                                    maxlength="20"
                                    class="ipt-text-notification"
                                    id="ipt-title-notification">
                            </div>
                            <div class="field-ipt-text field-content-notification">
                                <div
                                    contenteditable="true"
                                    placeholder="Please input content"
                                    required
                                    minlength="100"
                                    maxlength="200"
                                    class="ipt-text-notification"
                                    id="ipt-content-notification"></div>
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
                                <td class="name-param">region_nm</td>
                                <td>Region name</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td class="name-param">shop_id</td>
                                <td>Shop Name</td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="btn-new-param"><i data-feather="plus"></i></div>
                    </div>
                    <div class="section-option-btn">
                        <div id="btn-delete-new-template" class="btn btn-primary btn-opt-add-template">
                            Delete
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
    <script>
        function getCaretPosition(editableDiv) {
            var caretPos = 0,
                sel, range;
            if (window.getSelection) {
                sel = window.getSelection();
                if (sel.rangeCount) {
                    range = sel.getRangeAt(0);
                    if (range.commonAncestorContainer == editableDiv) {
                        caretPos = range.endOffset;
                    }
                }
            } else if (document.selection && document.selection.createRange) {
                range = document.selection.createRange();
                if (range.parentElement() == editableDiv) {
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
            let startPos = 0;
            edt.addEventListener('blur', event=>{
                if(window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode == edt||window.getSelection().getRangeAt(0).commonAncestorContainer == edt)
                {
                    startPos = window.getSelection().getRangeAt(0).endOffset
                }
            })



            nameParams.forEach(nameParam=>{
                nameParam.addEventListener("click",event => {
                    // edt.focus();
                    // edt.setSelectionRange(startPos, startPos);
                    const range = window.getSelection().getRangeAt(0);
                    const btn = document.createElement('button');
                    btn.textContent = event.currentTarget.textContent;
                    btn.contentEditable = false
                    // console.log(startPos,btn.outerHTML,edt.innerHTML.toString().slice(startPos, 0, btn.outerHTML))
                    edt.innerHTML = [edt.innerHTML.slice(0, startPos), btn.outerHTML, edt.innerHTML.slice(startPos)].join('')
                    startPos += btn.outerHTML.length
                    // range.insertNode(btn);
                    // range.collapse(false);
                })
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
        returnNotificationList.addEventListener('click', (e)=>{
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




































