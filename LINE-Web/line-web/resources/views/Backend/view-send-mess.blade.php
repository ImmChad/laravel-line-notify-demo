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
    {{-- display calendar --}}
    <link  rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"   />
        

    <style>

        :root
        {
            --green:#00c34d;
            --blue:#007bff;
        }

        .navigation-view-admin:hover {
            background: var(--blue);
        } 
        .navigation-view-admin:hover .direct-navigation {
            color: white !important;
        } 
        /* .direct-navigation:hover {
            color: blue;
        } */
    
    
        /* CSS TOAASST */
        .toast {
            position: fixed;
            top: 55px;
            right: 15px;
            /* border-radius: 20px; */
            background: #fff;
            padding: 20px 35px 20px 25px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            border: 4px solid var(--blue);
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
            background-color: #0073ff;
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
            background-color: #0088ff;
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
    


    <!-- Set Icon Logo -->
    <link rel="icon" href="{{ asset('Image/logo.png') }}">
    <title>Send Massage Admin View</title>
</head>
<body>
    <div style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column; background: #f0f1f6">
        <div class="row" style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: flex-start; padding: 1rem; background: #f0f1f6"">
            <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card scroll-card" style=" height: calc(100vh - 2rem); overflow-y: scroll;">
                        <div class="card-body">
                            <div style="display: flex;justify-content: space-between">
                                <div class="card-title col-sm-12" style="font-size: 20px; font-weight: 700; padding: 0px; border: 2px solid black; border-radius: 0.2rem;">
                                    {{-- <span class="announce_title" style="margin: 0rem 1rem;">Announce 1</span> --}}
                                    <input type="text" class="form-control" id="announce_title" placeholder="Enter announce title ... ">
                                </div>
                            </div>
                            
                            <div class="card-title col-sm-12 scroll-card" style="font-size: 20px; font-weight: 700; padding: 0px; border: 2px solid black; border-radius: 0.2rem; height: 350px; overflow-y: scroll;">
                                <span class="announce_content" style="padding: 0rem;">
                                    <textarea class="form-control input-ads scroll-card" id="announce_content" style="width: 100%; height: 100%; resize: none;" placeholder="Enter announce content ..."></textarea>
                                </span>
                            </div>

                            {{-- <div style="display: flex;justify-content: space-between">
                                <div class="card-title col-sm-12" style="font-size: 20px; font-weight: 700; padding: 0px; border: 2px solid black; border-radius: 0.2rem;">
                                    <input type="text" id="created_at" class="form-control"  placeholder="Enter date time to set timer, It can null ..." aria-label="Username" aria-describedby="basic-addon1" >
                                </div>
                            </div> --}}

                            <div style="display: flex;justify-content: space-between">
                                <div class="card-title col-sm-12" style="font-size: 20px; font-weight: 700; padding: 0px;  border-radius: 0.2rem;">
                                    <button id="submit-btn"  type="submit" class="btn btn-primary btn-submit-notify btn-send-mess">Send Announce</button>
                                </div>
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


        $('.btn-send-mess').click(() => {

            // const now = new Date();
            // const formattedDate = new Intl.DateTimeFormat('en-US', {
            //     year: 'numeric',
            //     month: '2-digit',
            //     day: '2-digit',
            //     hour: '2-digit',
            //     minute: '2-digit',
            //     second: '2-digit',
            //     hour12: false,
            // }).format(new Date(now));
    
            // const [month, day, year, ...time] = formattedDate.split(/[\s/:]/);
            // const newFormattedDate = `${year}/${month}/${day} ${time.join(":")}`;
            // let newDate = newFormattedDate.replace(',', "");
            
            // let created_at = $('#created_at').val();
            // let announce_content = $('#announce_content').val();
            // let announce_title = $('#announce_title').val();

            // let [dateChoose, timeChoose] = newDate.split(' ');
            // let [hourChoose, minuteChoose, secondChoose] = timeChoose.split(':');
            // let newHour = hourChoose.replace('24', '00');

            // newDate = dateChoose + " " + newHour + ":" + minuteChoose + ":" + secondChoose;

            // let diffInSeconds = "";

            // if(created_at.trim() != "") {
            //     const date1 = new Date(newDate);
            //     const date2 = new Date(created_at);
            //     diffInSeconds = (date2 - date1) / 1000;
            //     console.log(newDate);
            //     console.log(created_at);
            //     console.log(diffInSeconds);
            // } else {
            //     diffInSeconds = 0;
            // }
            // if(diffInSeconds < 0) {
            //     displayToast("Cann't enter this date in the past to set the timer!")
            // } else {
            //     if(announce_title.trim() != "" || announce_content.trim() != "") {
            //         // console.log(created_at + " " + announce_title + " " + announce_content);

            //         console.log(diffInSeconds);


            //         var form  = new FormData();
            //         form.append('message', announce_content);
            //         form.append('title', announce_title);
            //         form.append('delayTime', diffInSeconds);
            //         form.append('created_at', created_at);

    
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
            //                 console.log(data);
            //                 displayToast('Send Success!');
            //                 $('#created_at').val("");
            //                 $('#announce_content').val("");
            //                 $('#announce_title').val("");
            //             },
            //             error: function() {
            //                 displayToast('Can not add data!');
            //             }
            //         });
            //     } else {
            //         displayToast("Please, Enter full!");
            //     }
            // }


            let announce_content = $('#announce_content').val();
            let announce_title = $('#announce_title').val();

            if(announce_title.trim() != "" && announce_content.trim() != "") {
                    // console.log(created_at + " " + announce_title + " " + announce_content);

                if(announce_title.length > 50) {
                    displayToast("Title notification can't exceed 50 characters! ");
                } else if(announce_content.length > 160) {
                    displayToast("Content notification can't exceed 160 characters! ");
                } else {
                    var form  = new FormData();
                    form.append('message', announce_content);
                    form.append('title', announce_title);
                    form.append('delayTime', "0");
                    // form.append('created_at', created_at);
    
    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{URL::to("/admin/send-mess")}}',
                        method: 'post',
                        data: form,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            displayToast('Send Success!');
                            $('#announce_content').val("");
                            $('#announce_title').val("");
                        },
                        error: function() {
                            displayToast('Can not add data!');
                        }
                    });                
                }

            } else {
                displayToast("Please, Enter full!");
            }

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


    {{-- display calendar --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script >
        $('#created_at').each(function () {
            $(this).datetimepicker();
        });
    </script>
</body>

</html>
















