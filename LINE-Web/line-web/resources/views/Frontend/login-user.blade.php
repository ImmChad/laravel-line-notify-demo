<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN</title>

    <!-- Set Icon Logo -->
    <link rel="icon" href="{{ asset('Image/logo.png') }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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
</head>
<body>
    <div style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <a href="{{$authUrl}}" style="font-size: 20px; cursor: pointer; margin: 1rem 0rem;">Connect to Line</a>
        <a href="{{url($authGmail)}}" style="font-size: 20px; cursor: pointer; margin: 1rem 0rem;">Connect to Gmail</a>
        <a href="#" style="font-size: 20px; cursor: pointer; margin: 1rem 0rem;" onclick="displayToast('Feature is developing!')">Connect to SMS</a>
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
    </script>
</body>
</html>