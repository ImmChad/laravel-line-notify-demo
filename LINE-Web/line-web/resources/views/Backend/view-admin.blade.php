<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>

        :root
        {
            --green:#00c34d
        }
    
        @import 'root.css';
        .btn-submit-notify
        {
            background-color: var(--green) ;
        }
        .table-register tbody tr:nth-child(odd)
        {
            background-color: var(--green) !important ;
            color: white;
        }
    
        h1.text-title-manager {
            text-align: center;
        }
    
        .container-table-register,.container-form-send-notify {
            display: flex;
            justify-content: center;
        }
    
        .table-register,.form-send-notify {
            width: 90%;
        }
        #ipt_text_notify
        {
            min-width: 600px;
            min-height: 180px;
            resize: none;
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
    </style>
    
    <title>View Admin</title>
</head>
<body>
    <div class="title-manager">
      <h1 class="text-title-manager" >Table Register Notification Line</h1>
    </div>
    <div class="container-table-register">
        <table class="table table-striped table-register">
            <thead>
                <tr>
                    <th scope="col">User name</th>
                    <th scope="col">Email</th>
                    <th scope="col">State</th>
                    <th scope="col">Time Connected</th>
                    <th scope="col">Choose receiver</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataList as $subDataList )
                <tr>
                    <td>{{ $subDataList->displayName }}</td>
                    <td>{{ $subDataList->email }}</td>
                    <td>{{ $subDataList->status }}</td>
                    <td>{{ $subDataList->date }}</td>
                    <td>
                        <div class="form-check">
                            <input data-id-user="{{ $subDataList->userId }}" class="form-check-input cbx-receiver-choose" type="checkbox" value="" id="flexCheckChecked" >
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="container-form-send-notify">
        <form  id="form-send-notify">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Content Notify</label>
                <textarea type="texr" class="form-control" class="ipt_notify" id="ipt_text_notify"></textarea>
            </div>
            <button id="submit-btn" type="submit" class="btn btn-primary btn-submit-notify">Submit</button>
            <button class="btn btn-primary btn-select-all-notify">Select All</button>
        </form>
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




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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

        // window.addEventListener('load',event=>{
        //     loadEventFormSubmit();
        // })
        // function loadEventFormSubmit()
        // {
            
        // }
        var elForm = document.querySelector('#form-send-notify')
        if(elForm)
        {
            elForm.addEventListener('submit',event=>{
                event.preventDefault()
                $('#ipt_text_notify')
                var ipt_text_notify = elForm.querySelector('#ipt_text_notify')
                var elChoosed_receivers = document.querySelectorAll('.cbx-receiver-choose')
                elChoosed_receivers = Array.from(elChoosed_receivers)            
                var dataReceivers = elChoosed_receivers.map(choosed_receiver=>{
                    if(choosed_receiver.checked)
                    return choosed_receiver.getAttribute('data-id-user')
                })
                dataReceivers = dataReceivers.filter(dataReceiver=>dataReceiver)
                requestSendNotification(ipt_text_notify.value.trim(),dataReceivers)
            })
        }

        var btnSelectAll = elForm.querySelector('.btn-select-all-notify');
        btnSelectAll.addEventListener('click',event=>{
            event.preventDefault();
            var elChoosed_receivers = document.querySelectorAll('.cbx-receiver-choose')
            elChoosed_receivers.forEach(
                elChoosed_receiver=>{
                    elChoosed_receiver.checked=true
                }
            )
        })


        function requestSendNotification(textNotification,dataReceivers=[])
        {
            if(textNotification.length<=0)
            {
                displayToast('Please Enter input content notify')
                // alert('Please Enter input content notify')
            }
            else if (dataReceivers.length<=0)
            {
                displayToast('Please Select receiver')
                // alert('Please Select receiver')
            }
            else
            {
                var form  = new FormData();
                form.append('message', textNotification);
                form.append('listUserId', JSON.stringify(dataReceivers));  
                
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
                        document.querySelector('#ipt_text_notify').value = "";
                        displayToast('Send Success!');
                    },
                    error: function() {
                        displayToast('Can not add data!');
                    }
                });
                console.log(textNotification,dataReceivers);
            }
            
        }
    </script>
</body>

</html>
















