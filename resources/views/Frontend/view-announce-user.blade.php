@extends('Frontend.home-user')
@section('content')
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
        .container-fluid
        {
            padding: 0px !important !important;
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
                            <a style="" class="sidebar-link sidebar-title link-nav link-iframe-notification "
                               target="iframe-notification-user" href="/user/view-user">
                                <i data-feather="home"> </i>
                            </a>
                        </li>
                        <li class="language-nav">
                            <a style=""
                               class="sidebar-link sidebar-title link-nav link-iframe-notification active {{$announceCount > 0?'marked':''}}"
                               href="/user/notify/list">
                                <i data-feather="bell"> </i>
                            </a>
                        </li>
                        <li class="language-nav">
                            <a class="sidebar-link sidebar-title link-nav link-iframe-notification"
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-airplay m-0">
                                <path
                                    d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                            </svg>
                        </div>
                        <div class="ProfileCard-details">
                            <div class="ProfileCard-realName">@{{name}}</div>
                        </div>
                    </div>
                </script>
                <script class="empty-template" type="text/x-handlebars-template">
                    <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is
                        down, yikes!
                    </div></script>
            </div>
        </div>
            <div class="row"
                 style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: flex-start; padding: 1rem 0px; background: #f0f1f6"
            >
            <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card scroll-card" style=" height: calc(100vh - 2rem); overflow-y: scroll;">
                        <div class="card-body">
                            <div style="display: flex;justify-content: space-between">
                                <div class="card-title col-sm-9"
                                     style="font-size: 25px; font-weight: 600; padding-left: 0px;">ANNOUNCE
                                </div>
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

                                    @if($subDataList->read_at == "null")
                                        <tr data-link="/user/notification/{{$subDataList->id}}/detail"
                                            class="row_data_news"
                                            style="background: white; border-bottom: 1px solid #f0f1f6;font-weight:700">
                                            <td style="vertical-align: middle;">
                                                {{ date('Y/m/d',strtotime($subDataList->created_at)) }}
                                            </td>
                                            <td class="announce_name_row" style="vertical-align: middle;">
                                                <a href="/user/notification/{{$subDataList->id}}/detail"
                                                   style="color: black;text-decoration: none;">{{ $subDataList->announce_title }}</a>
                                            </td>
                                            <td class="announce_name_row" style="vertical-align: middle;">
                                                <div><a class="btn-detail-notification"
                                                        href="/user/notification/{{$subDataList->id}}/detail">View</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <tr data-link="/user/notification/{{$subDataList->id}}/detail"
                                            class="row_data_news"
                                            style="background: white; border-bottom: 1px solid #f0f1f6;">

                                            <td class="announce_name_row" style="vertical-align: middle;">
                                                {{ date('Y/m/d',strtotime($subDataList->created_at)) }}
                                            </td>
                                            <td class="announce_name_row" style="vertical-align: middle;">
                                                <a href="/user/notification/{{$subDataList->id}}/detail"
                                                   style="color: black;text-decoration: none;">{{ $subDataList->announce_title }}</a>
                                            </td>
                                            <td class="announce_name_row" style="vertical-align: middle;">
                                                <div><a class="btn-detail-notification"
                                                        href="/user/notification/{{$subDataList->id}}/detail">View</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>

                            </table>

                            {{ $dataList->appends(request()->input())->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
    <!-- footer start-->


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

@endsection














