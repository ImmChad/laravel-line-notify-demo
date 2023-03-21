<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <!-- Set Icon Logo -->
    <link rel="icon" href="{{ asset('Image/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('Image/logo.png') }}" type="image/x-icon">

    {{-- <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon"> --}}
    <title>Login</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/whether-icon.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toast.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
<style>
            .widget-joins:after
            {
                height: 0px;
            }
            body
            {
                display: flex;
                flex-direction: column;
                justify-content: center;
                height: 100vh;
            }
            .toast
            {
                max-height: 110px;
                width: max-content;
                max-width: 450px;
                overflow-y: auto;
                padding: 0;
            }
            .toast .toast-content {
                margin: 5px 5px;
            }
        </style>
    <div class="">

    
        <div class="row">
            <div style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <div class="container-fluid p-0">
                    <div class="row m-0">
                        <div class="col-12 p-0">
                            <div class="login-card">
                                <div>
                                    <div>
                                        <a class="logo" href="/" style="margin-bottom: 0px; display: flex; justify-content: center; align-items: center;">
                                            <img class="img-fluid for-light" src="{{ asset('Image/logo.png') }}" style="width: 50px; height: 50px;" alt="looginpage"> 
                                            <span style="font-size: 20px; display: flex; justify-content: center; align-items: center;">Girl Meee</span> 
                                        </a>
                                    </div>
                                    <div class="login-main">

                                        <form  class="theme-form" id="form-login-user">
                                            <h4 style="text-align:center">Login</h4>
                                            <!-- <p>Connect to Line, email or sms</p> -->
                                            <!-- <h6 class="text-muted mt-4 or"> Connect with</h6> -->
                                            <!-- <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div> -->
                                            <div class="mb-3">
                                                <label class="col-form-label" for="exampleInputEmail1">SMS Number</label>
                                                <input required class="form-control" id="sms_number" type="text"
                                                maxlength="15" minlength="10"    name="sms_number" placeholder="Format: +84123456789">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputName">Password</label>
                                                <input required class="form-control" id="password" type="password"
                                                maxlength="18" minlength="8"  name="password" placeholder="Password">
                                            </div>
                                            <a href="/signup-user" class="link-other-option">Sign Up NOW</a>
                                            <div class="text-sm-end">
                                                <button id="btn-login-user"class="btn btn-primary-gradien btn-send-it">LOGIN</button>
                                            </div>
                                        </form>
                                        
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
    </div>
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script> --}}

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>

   


    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
    <!-- Plugin used-->
    <script type="text/javascript">
        localStorage.clear();
        $(".page-wrapper").attr("class", "page-wrapper compact-wrapper modern-type");
        localStorage.setItem('page-wrapper', 'compact-wrapper modern-type');

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
    <script>
        @php
        if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
        @endphp
        @if(isset($_SESSION['toast']))
            displayToast("{!!$_SESSION['toast']!!}");
            @php
            unset($_SESSION['toast']);
            @endphp

        @endif
    </script>
    <script>
        let formLoginUser = document.querySelector("#form-login-user");
        formLoginUser.addEventListener('submit', (e)=> {
            e.preventDefault();
            
            submitLoginUser(formLoginUser)
            // formLoginUser.style.display="none";
            // formVerify.style.display="block";
        });

        function submitLoginUser(formElement) {
                    var form  = new FormData(formElement);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{URL::to("/login-user")}}',
                        method: 'post',
                        data: form,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            if(data.isLogined)
                            {
                                location.href=''
                            }
                            else
                            {
                                displayToast(data.mess)
                            }
                        },
                        error: function(error) {
                            displayToast(error.responseJSON.message)
                            // console.log(error.responseJSON.message);
                        }
                    });
        }      

    </script>

    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script> --}}



</body>

</html>
