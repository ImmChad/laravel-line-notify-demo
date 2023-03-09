<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap4.css'>


    <style>

        :root
        {
            --green:#00c34d;
            --blue:#007bff;
        }

        /* .navigation-view-admin:hover {
            background: var(--blue);
        } 
        .navigation-view-admin:hover .direct-navigation {
            color: white !important;
        }  */
    
        code {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: "Courier New", Courier, monospace;
            font-size: 1em;
            padding: 2px 4px;
            font-weight: bold;
            font-style: italic;
        }
    
        /* CSS TOAASST */
        .toast {
            position: fixed;
            top: 55px;
            right: 15px;
            /* border-radius: 20px; */
            background: #fff;
            padding: 20px 35px 20px 25px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            border: 4px solid var(--green);
            overflow: hidden;
            transform: translateX(calc(100% + 30px));
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.35);
            z-index: 1035;
            display: none;
        }
    
        .toast.active {
            transform: translateX(0%);
            opacity: 1 !important;
            display: block;
        }
    
        .toast .toast-content {
            display: flex;
            align-items: center;
        }
    
        .toast-content .check {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 35px;
            width: 35px;
            background-color: #4dff00;
            color: #fff;
            font-size: 20px;
            border-radius: 50%;
        }
    
        .toast-content .message {
            display: flex;
            flex-direction: column;
            margin: 0 20px;
        }
    
        .message .text {
            font-size: 20px;
            font-weight: 400;
            ;
            color: #666666;
        }
    
        .message .text.text-1 {
            font-weight: 600;
            color: #333;
        }
    
        .toast .close {
            position: absolute;
            top: 10px;
            right: 15px;
            padding: 5px;
            cursor: pointer;
            opacity: 0.7;
        }
    
        .toast .close:hover {
            opacity: 1;
        }
    
        .toast .progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background: #ddd;
        }
    
        .toast .progress:before {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            height: 100%;
            width: 100%;
            background-color: #4dff00;
        }
    
        .progress.active:before {
            animation: progress 5s linear forwards;
        }
    
        @keyframes progress {
            100% {
                right: 100%;
            }
        }


        

        .scroll-card::-webkit-scrollbar {
            display: none;
        }
    </style>
    
    <title>View Admin</title>
</head>
<body>
    <div style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column; background: #f0f1f6">
        {{-- <div class="page-header">
            <h3 class="page-title">
                Quản Lý Sản Phẩm
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="fa fa-certificate" aria-hidden="true" style="color: black;"></i>
                </span> 
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="mdi mdi-timetable"></i>
                        <span>php
                        $today = date('d/m/Y');
                        echo $today;
                        ></span>
                    </li>
                </ul>
            </nav>
        </div> --}}
    
        <div class="row" style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: flex-start; padding: 1rem; background: #f0f1f6"">
            <div class="col-sm-5" style="padding-left: 0px; padding-right: 0px;">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card scroll-card" style=" height: calc(100vh - 2rem); overflow-y: scroll;">
                        <div class="card-body">
                            <div style="display: flex;justify-content: space-between">
                                <div class="card-title col-sm-9" style="font-size: 25px; font-weight: 600; padding-left: 0px;">ANNOUNCE</div>
                            </div>
                            <nav aria-label="breadcrumb" style="border-radius: 0px">
                                <ul class="breadcrumb" style="border-radius: 0px; margin-bottom: 0px;">
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span>List Announce</span>
                                    </li>
                                </ul>
                            </nav>
                            <table style="background: white;" class="table table-striped">
                                <tbody>
                                    @foreach ($dataList as $subDataList)
                                        <tr class="row_data_news" style="background: white; border-bottom: 1px solid #f0f1f6;">
                                            <td style="vertical-align: middle;">{{ $subDataList->announce_title }}</td>
            
                                            <td style="vertical-align: middle;">
                                                {{ $subDataList->created_at }}
                                            </td>
            
                                            <td>
                                                <button id="submit-btn " announce_id="{{ $subDataList->id }}" type="submit" class="btn btn-primary btn-submit-notify btn-get-content">View</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
            
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7" style="padding-left: 0px; padding-right: 0px;">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card scroll-card" style=" height: calc(100vh - 2rem); overflow-y: scroll;">
                        <div class="card-body">
                            <div style="display: flex;justify-content: space-between">
                                <div class="card-title col-sm-12" style="font-size: 20px; font-weight: 700; padding-left: 0px; border: 2px solid black; border-radius: 0.2rem;">
                                    <span class="announce_title" style="margin: 0rem 1rem;"></span>
                                </div>
                            </div>
                            <nav aria-label="breadcrumb" style="border-radius: 0px">
                                <ul class="breadcrumb" style="border-radius: 0px; margin-bottom: 0px; background: none;">
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <span class="created_at"><?php
                                            $today = date('d/m/Y');
                                            echo $today;
                                            ?></span>
                                    </li>
                                </ul>
                            </nav>
                            <div class="card-title col-sm-12 scroll-card" style="font-size: 20px; font-weight: 700; border: 2px solid black; border-radius: 0.2rem; height: 550px; overflow-y: scroll;">
                                <span class="announce_content" style="padding: 1rem;">
                                    
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <div class="toast">
        <div class="toast-content">
            {{-- <i class="fa-solid fa-circle-info"></i> --}}
            <i class="fa fa-info check" aria-hidden="true"></i>
            {{-- <i class="fa-solid fa-circle-info"></i> --}}


            <div class="message">
                <span class="text text-1">Notification !!!</span>
                <span class="text text-2">Your changes has been saved</span>
            </div>
        </div>
        {{-- <i class="fa-solid fa-xmark close"></i> --}}
        <i class="fa fa-times close" aria-hidden="true" style="font-size: 20px;"></i>
        <div class="progress"></div>
    </div>



    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js'></script> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
    <script>

        @if(isset($messToast))
            displayToast('{{ json_decode($messToast) }}');
        @endif

        function displayToast(mess) {
            document.querySelector('.toast .text.text-2').textContent = mess;
            document.querySelector('.toast').classList.add('active');
            document.querySelector('.progress').classList.add('active');


            let time = setTimeout(() => {
                document.querySelector('.toast').classList.remove("active");
                document.querySelector('.progress').classList.remove("active");
            }, 5000); //1s = 1000 milliseconds

            document.querySelector(".toast .close").addEventListener("click", () => {
                document.querySelector('.toast').classList.remove("active");
                
                setTimeout(() => {
                    document.querySelector('.progress').classList.remove("active");
                }, 300);

                clearTimeout(time);
            });
        }

        let btnGetContent = document.querySelectorAll('.btn-get-content');
        btnGetContent.forEach((item) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();

                // console.log('click');

                var form  = new FormData();
                form.append('id', e.currentTarget.getAttribute('announce_id'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{URL::to("/admin/get-announce-content")}}',
                    method: 'post',
                    data: form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);

                        if(data.length == 0) {
                            $('.announce_title').text("Null");
                            $('.announce_content').text("Null");
                            $('.created_at').text("Null");
                        } else {
                            $('.announce_title').text(data[0].announce_title);
                            $('.announce_content').text(data[0].announce_content);
                            $('.created_at').text(data[0].created_at);
                        }
                        // displayToast('Send Success!');
                    },
                    error: function() {
                        displayToast('Can not add data!');
                    }
                });
            });
        });

        // function requestSendNotification(textNotification,dataReceivers=[])
        // {
        //     if(textNotification.length<=0)
        //     {
        //         displayToast('Please Enter input content notify')
        //         // alert('Please Enter input content notify')
        //     }
        //     else if (dataReceivers.length<=0)
        //     {
        //         displayToast('Please Select receiver')
        //         // alert('Please Select receiver')
        //     }
        //     else
        //     {
        //         var form  = new FormData();
        //         form.append('message', textNotification);
        //         form.append('listUserId', JSON.stringify(dataReceivers));  
                
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             }
        //         });
        //         $.ajax({
        //             url: '{{URL::to("/admin/send-mess")}}',
        //             method: 'post',
        //             data: form,
        //             contentType: false,
        //             processData: false,
        //             dataType: 'json',
        //             success: function(data) {
        //                 document.querySelector('#ipt_text_notify').value = "";
        //                 displayToast('Send Success!');
        //             },
        //             error: function() {
        //                 displayToast('Can not add data!');
        //             }
        //         });
        //         console.log(textNotification,dataReceivers);
        //     }
            
        // }
    </script>
</body>

</html>
















