@extends('Frontend.home-user')
@section('content')
    <div style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column;">
        {{-- <a href="{{$authUrl}}" style="font-size: 20px; cursor: pointer; margin: 1rem 0rem;">Connect to Line</a>
        <a href="{{url($authGmail)}}" style="font-size: 20px; cursor: pointer; margin: 1rem 0rem;">Connect to Gmail</a>
        <a href="#" style="font-size: 20px; cursor: pointer; margin: 1rem 0rem;" onclick="displayToast('Feature is developing!')">Connect to SMS</a> --}}
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
                            <form class="theme-form">
                                <h4>Connect to account</h4>
                                <p>Connect to Line, email</p>
                                <h6 class="text-muted mt-4 or"> Connect with</h6>
                                <div class="social mt-4">
                                    <div class="btn-showcase" style="width: 100%; display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                        <a class="btn btn-light" style="margin: 0.5rem 0rem;" href="{{$authUrl}}" target="_blank"><i class="txt-linkedin" data-feather="message-circle"></i>LINE</a>
                                        <a class="btn btn-light" style="margin: 0.5rem 0rem;" href="{{url($authGmail)}}" target="_blank"><i class="txt-twitter" data-feather="mail"></i>GMAIL</a>
                                    </div>
                                </div>
                            </form>
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









    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>

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
@endsection
