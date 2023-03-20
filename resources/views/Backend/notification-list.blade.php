@extends('Backend.backend-view')
@section('ContentAdmin')
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
    </style>
    {{-- <div class="title-manager">
    <h1 class="text-title-manager" >Table Register Notification Line</h1>
    </div> --}}

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
                        <div class="btn btn-outline-primary ms-2 btn-new-notification" style="display: flex; justify-content: center; align-items: center; width: 300px;">
                            <i data-feather="send"></i>New Notification  
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
                            <th scope="col">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dataList as $subDataList )
                        <tr class="link-detail-announce" data-id-notification='{{$subDataList->id}}'>
                            <td >{{$subDataList->name_type}}</td>
                            <td>{{$subDataList->announce_title}}</td>
                            <td>{{$subDataList->created_at}}</td>
                            <td>
                            <div class="btn-management">Show</div>
                            <div class="btn-management">Update</div>
                            <div class="btn-management">Delete</div>
                            <div class="btn-management">Show User readed</div></td>

                        </tr>
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
        var tr_announces = document.querySelectorAll('.link-detail-announce');
        tr_announces.forEach(tr_announce=>{
            tr_announce.addEventListener('click',event=>{
                location.href =`/admin/notification/${event.currentTarget.getAttribute('data-id-notification')}/detail`
            })
        })
        let btnNewNotification = document.querySelector('.btn-new-notification');
        btnNewNotification.addEventListener('click', (e)=> {
            $('.parent-form-popup').css("display", "flex");
            $('.parent-form-popup .title-popup').text("Choose a method of notification");

            let newHtml = `
                <button class="btn-lg btn-primary send-notification" notification_type="2">Total Everyone</button>
                <button class="btn-lg btn-info send-notification" notification_type="3">Only Email</button>
            `;
            // document.querySelector('.parent-form-popup .faq-form').insertAdjacentHTML('beforeend', newHtml);
            document.querySelector('.parent-form-popup .faq-form').innerHTML = newHtml;

            let sendNotification = document.querySelectorAll('.send-notification');
            sendNotification.forEach((item) => {
                item.addEventListener('click', (e) => {
                    let notification_type = e.currentTarget.getAttribute('notification_type');
                    window.location.href = "/admin/send-notification-view/" + notification_type;
                });
            
            })

            $('.parent-form-popup .close-popup').click(function() {
                $('.parent-form-popup').css("display", "none");
            });


        });

    </script>

<script defer>
        
        var btn_search= document.querySelector("#btn-submit-search-notification");
        btn_search.addEventListener('click',(event)=>{
            var  ipt_search = document.querySelector("#ipt-search-notification");
            var url = new URL(location.href); 
            url.searchParams.set('txt-search-notification', ipt_search.value);
            location.href = url.toString();
            // console.log(url.toString());
            // var form  = new FormData();
                // form.append('txt-search-notification', ipt_search.value);
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                // $.ajax({
                //     url: '{{URL::to("/admin/search-notification")}}',
                //     method: 'post',
                //     data: form,
                //     contentType: false,
                //     processData: false,
                //     dataType: 'json',
                //     success: function(data) {
                //         document.querySelector('#table-list-notification tbody').innerHTML=
                //             `
                //             ${                
                //             data.map(subDataList=>{
                //             return `
                //             <tr class="link-detail-announce" data-id-notification='${subDataList.id}'>
                //             <td>${subDataList.name_type}</td>
                //             <td>${subDataList.announce_title}</td>
                //             <td>${subDataList.created_at}</td>
                //         </tr>
                //             `
                //         }).join('')}
                //             `
                //         console.log(data);
                //     },
                //     error: function() {
                //     }
                // });
        })

                
    </script>
@endsection

 



































