@extends('Backend.backend-view')
@section('ContentAdmin')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        .link-detail-announce
        {
            cursor: pointer;
        }
        .widget-joins:after {
            height:0px !important;
        }
        .widget-joins .media .media-body svg {
            width: 30px;
            height: 30px;
        }
        .btn-new-notification {
            border: 2px solid var(--theme-deafult);
            color: var(--theme-deafult);
        }
        .btn-new-notification:hover {
            background: var(--theme-deafult);
            color: white;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d  !important;
        }
    </style>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header" style="padding: 10px 40px;">
                <div class="media" style="display: flex; padding: 0px;">
                    <form class="form-inline" style=" border: 1px solid #f4f4f4;  padding: 0px 20px; border-radius: 5px;">
                        <div class="form-group mb-0" style="justify-content: center; align-items: center;">
                            <i id="btn-submit-search-notification" class="fa fa-search" style="padding-right: 10px" ></i>
                            <input id="ipt-search-notification" class="form-control-plaintext" type="text" value="{{isset($_GET['txt-search-notification'])?$_GET['txt-search-notification']:''}}" placeholder="Search title notification">
                        </div>
                    </form>
                    <div class="media-body text-end" style="display: flex; justify-content: flex-end;">
                        <div class="btn-group">
                            <button
                                class="btn dropdown-toggle btn-outline-primary ms-2 btn-new-notification"
                                style="display: flex; justify-content: center; align-items: center;"
                                data-toggle="dropdown"
                                >
                                <i data-feather="send"></i>New Notification
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/admin/send-notification-view/2">Total Everyone</a>
                                <a class="dropdown-item" href="/admin/send-notification-view/3/">Only Email</a>
                            </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 40px;">
                <div>
                    <h5>Notification List</h5>
                    <span>This is table contain notification list.</span>
                </div>
                <div>

                </div>
            </div>
            <div class="table-responsive">
                <table id="table-list-notification" class="table">
                    <thead>
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Title</th>
                            <th scope="col">Time</th>
                            <th scope="col">View</th>
                            <th scope="col">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dataList as $subDataList )
                        @if($subDataList->deleted_at == null)
                            <tr class="link-detail-announce" data-id-notification='{{$subDataList->id}}' style="">
                                <td >{{$subDataList->name_type}}</td>
                                <td>{{$subDataList->announce_title}}</td>
                                <td>{{$subDataList->created_at}}</td>
                                <td>{{$subDataList->read_user}}/{{$subDataList->total_user}}</td>
                                <td>
                                    <button class="btn btn-success btn-update-notification" data-id-notification='{{$subDataList->id}}' {{$subDataList->is_sent==1?'disabled':''}} >Update</button>
                                    <button class="btn btn-danger btn-delete-notification" data-id-notification='{{$subDataList->id}}'>Delete</button>
                                    <button class="btn btn-primary btn-show-details-notification" data-id-notification='{{$subDataList->id}}'>Show</button>
                                </td>
                            </tr>
                        @else
                            <tr class="link-detail-announce" data-id-notification='{{$subDataList->id}}' >
                                <td style="color: #b6afaf !important;">{{$subDataList->name_type}}</td>
                                <td style="color: #b6afaf !important;">{{$subDataList->announce_title}}</td>
                                <td style="color: #b6afaf !important;">{{$subDataList->created_at}}</td>
                                <td style="color: #b6afaf !important;">{{$subDataList->read_user}}/{{$subDataList->total_user}}</td>
                                <td>
                                    <button class="btn btn-secondary btn-update-notification" disabled style="background-color: #6c757d !important; border-color: #6c757d  !important;">Update</button>
                                    <button class="btn btn-secondary btn-delete-notification" disabled style="background-color: #6c757d !important; border-color: #6c757d  !important;">Delete</button>
                                    <button class="btn btn-secondary btn-show-details-notification" data-id-notification='{{$subDataList->id}}' disabled style="background-color: #6c757d !important; border-color: #6c757d  !important;">Show</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div class="control-page">
                    {{ $dataList->appends(request()->input())->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>


    <script>
        let btnShowDetailsNotification = document.querySelectorAll('.btn-show-details-notification');
        btnShowDetailsNotification.forEach(item => {
            item.addEventListener('click', event => {
                location.href =`/admin/notification/${event.currentTarget.getAttribute('data-id-notification')}/detail`
            })
        });

        let btnDeleteNotification = document.querySelectorAll('.btn-delete-notification');
        btnDeleteNotification.forEach((item) => {
            item.addEventListener('click', event => {
                location.href = `/admin/notification/delete/${event.currentTarget.getAttribute('data-id-notification')}`
            })
        });

        let btnUpdateNotification = document.querySelectorAll('.btn-update-notification');
        btnUpdateNotification.forEach((item) => {
            item.addEventListener('click', event => {
                location.href = `/admin/update-notification-view/${event.currentTarget.getAttribute('data-id-notification')}`
            })
        });


        let btnNewNotification = document.querySelector('.btn-new-notification');
        // btnNewNotification.addEventListener('click', (e)=> {
        //     $('.parent-form-popup').css("display", "flex");
        //     $('.parent-form-popup .title-popup').text("Choose a method of notification");

        //     let newHtml = `
        //         <button class="btn-lg btn-primary send-notification" notification_type="2">Total Everyone</button>
        //         <button class="btn-lg btn-info send-notification" notification_type="3">Only Email</button>
        //     `;
        //     // document.querySelector('.parent-form-popup .faq-form').insertAdjacentHTML('beforeend', newHtml);
        //     document.querySelector('.parent-form-popup .faq-form').innerHTML = newHtml;

        //     let sendNotification = document.querySelectorAll('.send-notification');
        //     sendNotification.forEach((item) => {
        //         item.addEventListener('click', (e) => {
        //             let notification_type = e.currentTarget.getAttribute('notification_type');
        //             window.location.href = "/admin/send-notification-view/" + notification_type;
        //         });

        //     })

        //     $('.parent-form-popup .close-popup').click(function() {
        //         $('.parent-form-popup').css("display", "none");
        //     });


        // });

    </script>

    <script defer>
        var btn_search= document.querySelector("#btn-submit-search-notification");
        btn_search.addEventListener('click',(event)=>{
            var  ipt_search = document.querySelector("#ipt-search-notification");
            var url = new URL(location.href);
            url.searchParams.set('txt-search-notification', ipt_search.value);
            location.href = url.toString();
        })
    </script>

@endsection





































