@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins:after
        {
            height: 0px;
        }
    </style>

    <div class="row" style="display: flex; justify-content: center; align-items: center;">
        <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12 box-col-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h5>Update Notification</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li class="return-notification-list"><i data-feather="corner-down-left" style="cursor: pointer;"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="card-header" style="padding: 0px 40px;">
                    <select class="form-select digits" id="dataTemplate" >
                        <option template_id="0" template_name="null">Choose Template</option>
                        @foreach ($dataTemplate as $subDataTemplate)
                            <option template_id="{{ $subDataTemplate->id }}" template_name="{{ $subDataTemplate->template_name }}">{{ $subDataTemplate->template_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="contact-form card-body">
                    <form class="theme-form">
                        <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                        <div class="mb-3">
                            <label for="exampleInputName">Notification title</label>
                            <input class="form-control" id="announce_title" type="text" value="{{$dataNotification->announce_title}}">
                            <input class="form-control" id="announce_id" type="text"  style="display: none;" value="{{$dataNotification->id}}">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="exampleInputEmail1">Notification content</label>


                            <textarea class="form-control textarea" id="announce_content" rows="3" cols="50" placeholder="Your Message">{{$dataNotification->announce_content}}</textarea>
                        </div>
                        <div class="text-sm-end">
                            <button class="btn btn-primary-gradien btn-update-it">UPDATE IT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="{{asset('assets/js/editor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{asset('assets/js/email-app.js')}}"></script>


    <script>

        let dataTemplate = document.querySelector('#dataTemplate');
        dataTemplate.addEventListener('change', (e) => {
            let template_id = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('template_id');
            let template_name = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('template_name');


            if(template_id != 0) {
                var form  = new FormData();
                form.append('template_id', template_id);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{URL::to("/admin/get-template-for-send-mail")}}',
                    method: 'post',
                    data: form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {


                        var announce_content = CKEDITOR.instances['announce_content'];
                        let newDiv = `${data.template_content}`;
                        announce_content.insertHtml(newDiv);

                        document.querySelector('#announce_title').value = data.template_title;

                    },
                    error: function() {
                        displayToast('Can not add data!');
                    }
                });
            } else {

            }
        })


        let returnNotificationList = document.querySelector('.return-notification-list');
        returnNotificationList.addEventListener('click', (e)=>{
            window.location.href = "/admin/notification-list";
        });

        let btnUpdateIt = document.querySelector('.btn-update-it');
        btnUpdateIt.addEventListener('click', (e)=> {
            e.preventDefault();

            var editorData = CKEDITOR.instances.announce_content.getData();
            let announce_content = editorData;
            let announce_title = $('#announce_title').val();
            let announce_id = $('#announce_id').val();

            if(announce_title.trim() != "" && announce_content.trim() != "") {

                var form  = new FormData();
                form.append('announce_id', announce_id);
                form.append('message', announce_content);
                form.append('title', announce_title);

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
                    success: function(data) {
                        window.location.href = "/admin/notification-list";
                    },
                    error: function() {
                        displayToast('Can not add data!');
                    }
                });
            } else {
                displayToast("Please, Enter full!");
            }


        });






    </script>
@endsection




































