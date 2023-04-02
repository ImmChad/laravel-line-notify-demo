@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins:after
        {
            height: 0px;
        }
    </style>

    <div class="row" style="display: flex; justify-content: center; align-items: center;">
        <div class="col-sm-12 col-lg-6 col-xl-8 xl-50 col-md-12 box-col-6">
            <div class="card height-equal">
                <div class="card-header">
                    <h5>Update Notification</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li class="return-notification-list"><i data-feather="corner-down-left" style="cursor: pointer;"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="contact-form card-body">
                    <form class="theme-form">
                        <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                        <div class="mb-3">
                            <label for="exampleInputName">Notification title</label>
                            <input class="form-control" id="announce_title" type="text" placeholder="John Dio" value="{{$dataNotification->announce_title}}">
                            <input class="form-control" id="announce_id" type="text"  style="display: none;" value="{{$dataNotification->id}}">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="exampleInputEmail1">Notification content</label>
                            <textarea class="form-control textarea" id="announce_content" rows="3" cols="50" placeholder="Your Message">{{$dataNotification->announce_content}}</textarea>
                        </div>
                        <div class="text-sm-end">
                            <button class="btn btn-primary-gradien btn-update-it">UDATE IT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let returnNotificationList = document.querySelector('.return-notification-list');
        returnNotificationList.addEventListener('click', (e)=>{
            window.location.href = "/admin/notification-list";
        });

        let btnUpdateIt = document.querySelector('.btn-update-it');
        btnUpdateIt.addEventListener('click', (e)=> {
            e.preventDefault();

            let announce_content = $('#announce_content').val();
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

















