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
    <title>User Notification</title>
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
    @yield('style')
</head>

<body>
<style>
    .page-wrapper .page-header .header-wrapper {
        padding: 0.2rem 1rem;
    }

    .nav-menus path, .nav-menus a {
        color: black;
    }

    /* .nav-menus:hover path, .nav-menus a:hover{
        color:var(--theme-deafult)!important;
    } */
    .nav-menus a.active path, .nav-menus a.active {
        color: var(--theme-deafult) !important;

    }

    .nav-menus a.marked {
        position: relative;
    }

    .nav-menus a.marked::after {
        position: absolute;
        content: "";
        width: 10px;
        height: 10px;
        background: var(--theme-deafult);
        border-radius: 50%;
        right: 0;
    }
</style>
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper modern-type" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <form class="form-inline search-full col" action="#" method="get">
                <div class="form-group w-100">
                    <div class="Typeahead Typeahead--twitterUsers">
                        <div class="u-posRelative">
                            <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                   placeholder="Search Cuba .." name="q" title="" autofocus>
                            <div class="spinner-border Typeahead-spinner" role="status">
                                <span class="sr-only">Loading...</span></div>
                            <i class="close-search" data-feather="x"></i>
                        </div>
                        <div class="Typeahead-menu"></div>
                    </div>
                </div>
            </form>
            <div class="header-logo-wrapper col-auto p-0">
                {{-- <div class="logo-wrapper"><a href="{{ route('index') }}"><img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt=""></a></div> --}}
                <div class="logo-wrapper"><a href="#"><img class="img-fluid"
                                                           style="width: 40px; height: 40px; object-fit: cover;"
                                                           src="{{ asset('Image/logo.png') }}" alt=""></a>
                </div>
            </div>
            <div class="left-header col horizontal-wrapper ps-0">
                <ul class="horizontal-menu">
                    <li class="mega-menu outside">
                        <a class="nav-link" href="#"><span>Girl Meee</span></a>

                    </li>
                </ul>
            </div>
            <div class="nav-right col-8 pull-right right-header p-0">
                <ul class="nav-menus">
                    <li class="language-nav">
                        <a style="" class="sidebar-link sidebar-title link-nav link-iframe-notification {{ Route::currentRouteName()=='setting-notification-user' ? '' : 'active' }}"
                           target="iframe-notification-user" href="/user/view-user">
                            <i data-feather="home"> </i>
                        </a>
                    </li>
                    <li class="language-nav">
                        <a style=""
                           class="sidebar-link sidebar-title link-nav link-iframe-notification {{$announceCount > 0?'marked':''}}"
                           href="/user/notify/list">
                            <i data-feather="bell"> </i>
                        </a>
                    </li>
                    <li class="language-nav">
                        <a class="sidebar-link sidebar-title link-nav link-iframe-notification {{ Route::currentRouteName()=='setting-notification-user' ? 'active' : '' }}"
                           target="iframe-notification-user" href="/user/setting-notification">
                            <i data-feather="settings"> </i>
                        </a>
                    </li>

                    <li>
                        <a href="/logout-user">
                            <i data-feather="log-in"> </i>
                        </a>
                    </li>

                </ul>
            </div>
            <script class="result-template" type="text/x-handlebars-template">
                <div class="ProfileCard u-cf">
                    <div class="ProfileCard-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-airplay m-0">
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                            <polygon points="12 15 17 21 7 21 12 15"></polygon>
                        </svg>
                    </div>
                    <div class="ProfileCard-details">
                        <div class="ProfileCard-realName">@{{name}}</div>
                    </div>
                </div>
            </script>
            <script class="empty-template" type="text/x-handlebars-template">
                <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down,
                    yikes!
                </div></script>
        </div>
    </div>
    <!-- Page Header Ends -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <div class="page-body" style="margin:10px;margin-top:80px">
            <div class="row">
                <div class="col-xl-6 xl-100 box-col-12">
                    @yield("content")
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
<!-- footer start-->
{{-- <footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright text-center">
                <p class="mb-0">Copyright {{ date('Y') }} © Cuba theme by pixelstrap </p>
            </div>
        </div>
    </div>
</footer> --}}
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
    displayToast('{{ $messToast }}');
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
    console.log(document.querySelector('body').toDataURL());
    var links = document.querySelectorAll(".link-iframe-notification");
    links.forEach(link => {
        link.addEventListener('click', (event) => {
            links.forEach(link => {
                link.classList.remove("active")
            })
            console.log("Click");
            event.currentTarget.classList.add("active")
        })
    })
</script>
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script> --}}

@yield('script')
</body>

</html>
