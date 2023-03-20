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
    <title>Admin Notification</title>
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
                    <div class="logo-wrapper"><a href="#"><img class="img-fluid" style="width: 40px; height: 40px; object-fit: cover;"
                                src="{{ asset('Image/logo.png') }}" alt="" ></a>
                    </div>

                    <div class="toggle-sidebar">
                        <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
                    </div>
                </div>
                <div class="left-header col horizontal-wrapper ps-0">
                    <ul class="horizontal-menu">
                        <li class="mega-menu outside">
                            <a class="nav-link" href="#"><span>Girl Meee</span></a>
                            {{-- <div class="mega-menu-container nav-submenu menu-to-be-close header-mega">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col mega-box">
                                            <div class="mobile-title d-none">
                                                <h5>Mega menu</h5>
                                                <i data-feather="x"></i>
                                            </div>
                                            <div class="link-section icon">
                                                <div>
                                                    <h6>Error Page</h6>
                                                </div>
                                                <ul>
                                                    <li><a href="#">Error page 400</a></li>
                                                    <li><a href="#">Error page 401</a></li>
                                                    <li><a href="#">Error page 403</a></li>
                                                    <li><a href="#">Error page 404</a></li>
                                                    <li><a href="#">Error page 500</a></li>
                                                    <li><a href="#">Error page 503</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col mega-box">
                                            <div class="link-section doted">
                                                <div>
                                                    <h6> Authentication</h6>
                                                </div>
                                                <ul>
                                                    <li><a href="#">Login Simple</a></li>
                                                    <li><a href="#">Login Bg Image</a></li>
                                                    <li><a href="#">Login Bg video</a></li>
                                                    <li><a href="#">Register Simple</a></li>
                                                    <li><a href="#">Register Bg Image</a></li>
                                                    <li><a href="#">Register Bg video</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col mega-box">
                                            <div class="link-section dashed-links">
                                                <div>
                                                    <h6>Usefull Pages</h6>
                                                </div>
                                                <ul>
                                                    <li><a href="#">Search Website </a></li>
                                                    <li><a href="#">Unlock User</a></li>
                                                    <li><a href="#">Forget Password</a></li>
                                                    <li><a href="#">Reset Password</a></li>
                                                    <li><a href="#">Maintenance</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col mega-box">
                                            <div class="link-section">
                                                <div>
                                                    <h6>Email templates</h6>
                                                </div>
                                                <ul>
                                                    <li><a href="#">Basic Email</a></li>
                                                    <li><a href="#">Basic With Header</a></li>
                                                    <li><a href="#">Ecomerce Template</a></li>
                                                    <li><a href="#">Email Template 2</a></li>
                                                    <li><a href="#">Ecommerce Email</a></li>
                                                    <li><a href="#">Order Success</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col mega-box">
                                            <div class="link-section">
                                                <div>
                                                    <h6>Coming Soon</h6>
                                                </div>
                                                <ul class="svg-icon">
                                                    <li><a href="#"> <i data-feather="file"> </i>Coming-soon</a>
                                                    </li>
                                                    <li><a href="#"> <i data-feather="film">
                                                            </i>Coming-video</a></li>
                                                    <li><a href="#"><i data-feather="image">
                                                            </i>Coming-Image</a></li>
                                                </ul>
                                                <div>
                                                    <h6>Other Soon</h6>
                                                </div>
                                                <ul class="svg-icon">
                                                    <li><a class="txt-primary" href="#"> <i
                                                                data-feather="cast"></i>Landing Page</a></li>
                                                    <li><a class="txt-secondary" href="#"> <i
                                                                data-feather="airplay"></i>Sample Page</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </li>
                        {{-- <li class="level-menu outside">
                            <a class="nav-link" href="#!"><i data-feather="inbox"></i><span>Level
                                    Menu</span></a>
                            <ul class="header-level-menu menu-to-be-close">
                                <li><a href="#" data-original-title="" title=""> <i
                                            data-feather="git-pull-request"></i><span>File manager </span></a></li>
                                <li>
                                    <a href="#!" data-original-title="" title=""> <i
                                            data-feather="users"></i><span>Users</span></a>
                                    <ul class="header-level-sub-menu">
                                        <li><a href="#" data-original-title="" title=""> <i
                                                    data-feather="user"></i><span>User Profile</span></a></li>
                                        <li><a href="#" data-original-title="" title=""> <i
                                                    data-feather="user-minus"></i><span>User Edit</span></a></li>
                                        <li><a href="#" data-original-title="" title=""> <i
                                                    data-feather="user-check"></i><span>Users Cards</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="#" data-original-title="" title=""> <i
                                            data-feather="airplay"></i><span>Kanban Board</span></a></li>
                                <li><a href="#" data-original-title="" title=""> <i
                                            data-feather="heart"></i><span>Bookmark</span></a></li>
                                <li><a href="#" data-original-title="" title=""> <i
                                            data-feather="zap"></i><span>Social App </span></a></li>
                            </ul>
                        </li> --}}
                    </ul>
                </div>
                <div class="nav-right col-8 pull-right right-header p-0">
                    <ul class="nav-menus">
                        <li class="language-nav">
                            <div class="translate_wrapper">
                                <div class="current_lang">
                                    <div class="lang"><i class="flag-icon flag-icon-us"></i><span
                                            class="lang-txt">EN </span></div>
                                </div>
                                <div class="more_lang">
                                    <a href="{{ route('lang', 'en' )}}" class="{{ (App::getLocale()  == 'en') ? 'active' : ''}}">
                                        <div class="lang {{ (App::getLocale()  == 'en') ? 'selected' : ''}}" data-value="en"><i class="flag-icon flag-icon-us"></i> <span class="lang-txt">English</span><span> (US)</span></div>
                                    </a>
                                    <a href="{{ route('lang' , 'de' )}}" class="{{ (App::getLocale()  == 'de') ? 'active' : ''}} ">
                                        <div class="lang {{ (App::getLocale()  == 'de') ? 'selected' : ''}}" data-value="de"><i class="flag-icon flag-icon-vn"></i> <span class="lang-txt">Vietnam</span><span> (VN)</span></div>
                                    </a>
                                    <a href="{{ route('lang' , 'es' )}}" class="{{ (App::getLocale()  == 'en') ? 'active' : ''}}">
                                        <div class="lang {{ (App::getLocale()  == 'es') ? 'selected' : ''}}" data-value="es"><i class="flag-icon flag-icon-jp"></i> <span class="lang-txt">Japan</span><span> (JP)</span></div>
                                    </a>
                                    
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="mode"><i class="fa fa-moon-o"></i></div>
                        </li>
                        <li class="maximize"><a class="text-dark" href="#!"
                                onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                        <li class="profile-nav onhover-dropdown p-0 me-0">
                            <div class="media profile-media">
                                <img class="b-r-10" style="width: 40px; height: 40px; object-fit: cover;" src="{{ asset('assets/images/dashboard/boy_chu_tich.png') }}"
                                    alt="">
                                <div class="media-body">
                                    <span>Tung Admin</span>
                                    <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="/admin/log-out"><i data-feather="log-in"> </i><span>Log out</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
                    <div class="ProfileCard u-cf">                        
                    <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
                    <div class="ProfileCard-details">
                    <div class="ProfileCard-realName">@{{name}}</div>
                    </div>
                    </div>
                </script>
                <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
            </div>
        </div>
        <!-- Page Header Ends -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper">
                <div>
                    <div class="logo-wrapper">
                        <a href="#">
                            {{-- <img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo.png') }}" alt=""> --}}
                                {{-- <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}"
                                alt=""> --}}
                                <img class="img-fluid for-light" style="width: 40px; height: 40px; object-fit: cover;"
                                src="{{ asset('Image/logo.png') }}" alt="" >
                                <img class="img-fluid for-dark" style="width: 40px; height: 40px; object-fit: cover;"
                                src="{{ asset('Image/logo.png') }}" alt="" >
                        </a>
                        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle"
                                data-feather="grid"> </i></div>
                    </div>
                    <div class="logo-icon-wrapper"><a href="#"><img class="img-fluid"
                                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
                    <nav class="sidebar-main">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="sidebar-menu">
                        <ul class="sidebar-links" id="simple-bar">
                                <li class="back-btn">
                                    <a href="#"><img class="img-fluid"
                                            src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                                    <div class="mobile-back text-end"><span>Back</span><i
                                            class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                                </li>
                                <li class="sidebar-main-title">
                                    <div>
                                        <h6 class="lan-1">{{ trans('lang.General') }} </h6>
                                        <p class="lan-2">{{ trans('lang.Dashboards,widgets & layout.') }}</p>
                                    </div>
                                </li>
                                <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='register-line-list' ? 'active' : '' }}" href="/admin/register-line-list">
                                        <i data-feather="list"> </i><span>{{ trans('lang.Register Line List') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='notification-list' ? 'active' : '' }}" href="/admin/notification-list">
                                        <i data-feather="bell"> </i><span>{{ trans('lang.Notification List') }}</span>
                                    </a>
                                </li>
                                <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='template-management' ? 'active' : '' }}" href="/admin/template-management">
                                        <i data-feather="airplay"> </i><span>{{ trans('lang.Template Management') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </nav>
                </div>
            </div>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <!-- Container-fluid starts-->
                <div class="container-fluid" style="padding: 30px 0px !important; ">
                    <div class="row">
                        <div class="col-xl-6 xl-100 box-col-12">
                            <div class="widget-joins card widget-arrow">
                                <div class="row">
                                    @yield('ContentAdmin')
                                </div>
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

    <div class="parent-form-popup">
        <div class="row">
            <div class="col-lg-12 form-popup">
                <div class="card card-mb-faq xs-mt-search">
                    <div class="card-header faq-header" style="display: flex; justify-content: space-between;">
                        <h5 class="title-popup">Choose a method of notification</h5>
                        <i class="close-popup" style="width: 50px;" data-feather="x" style="cursor: pointer;"></i>
                    </div>
                    <div class="card-body faq-body">
                        <div class="faq-form">
                            {{-- <button class="btn-lg btn-primary">Total Everyone</button>
                            <button class="btn-lg btn-info">Only Email</button> --}}
                        </div>
                    </div>
                </div>
            </div>
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


    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script> --}}



    @yield('script')
</body>

</html>
