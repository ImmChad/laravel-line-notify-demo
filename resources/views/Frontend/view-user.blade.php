<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Set Icon Logo -->
    <link rel="icon" href="{{ asset('Image/logo.png') }}">
    <title>VIEW</title>


    <style>
        /* @import 'root.css'; */
        :root {
            --green: #00c34d;
            --blue: #007bff;
            --bluePreHover: rgb(183 216 249 / 66%);
            --whitePostHover: rgba(255, 255, 255, 0.67);
        }

        * {
            /* font-family: 'Comic Sans MS'; */
            box-sizing: border-box;
        }

        .title-profile-register {
            background: var(--blue);
            color: white;
            font-size: 34px;
            padding: 0px 20px;
        }

        tr.field-client,
        tr.field-user {
            margin-bottom: 20px;
            border-spacing: 20px solid transparent;
            display: flex;
            justify-content: space-between;
        }

        .content-user,
        .content-client {
            border-collapse: separate;
            border-spacing: 0 10px;
            width: 100%;
        }

        td.label-field-client,
        td.label-field-user {
            color: gray;
            margin-right: 30px;
        }

        .value-field-client {
            font-weight: bold;
        }

        .hr-profile-register {
            width: 80%;
            background-color: gray;
            height: .1px;
        }

        .part-display-secret {
            min-width: 250px;
            font-size: 20px;
            background-color: gray;
            height: 100%;
            margin-right: 10px;
        }

        .value-field-client {
            display: flex;
            align-items: center;
        }

        .label-field-user,
        .label-field-client {
            width: 170px;
        }

        .btn-secret {
            margin-right: 10px;
            border: 1px solid black;
            border-radius: 2px;
            padding: 0px 12px;
            cursor: pointer;
            color: gray;
        }

        .part-preview-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid black;
            position: relative;
        }

        .img-preview-avatar {

            position: absolute;

            width: 100%;

            height: 100%;
        }

        #ipt-file-avatar {

            display: none;
        }

        .btn-upload-avatar {
            position: absolute;
            bottom: 0px;
            right: 0px;
            border-radius: 50%;
            background-color: white;
            color: gray;
            padding: 5px;
            transform: translateX(-25%)translateY(-25%);
            border: 1px solid;
            cursor: pointer;
        }

        .name-client {
            font-size: 30px;
        }

        .ipt-field-user {
            min-height: 30px;
            min-width: 300px;
            padding: 0;
            width: 100%;
            outline: none;
            border: 1px solid gray;
            border-radius: 2px;
            padding: 0px 10px;
            color: black;
        }

        .body-profile-register {
            width: max-content;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 600px;
        }




        .container-profile-register {
            width: max-content;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 1px 1px 1px 1px gray;
        }

        .header-profile-register {
            width: 100%;
        }

        .section-user,
        .section-client {
            width: 100%;
        }

        .label-field-user {
            position: relative;
        }

        .label-field-user.marked::after {
            content: '\f111';
            font-family: "Font Awesome 5 Free";
            color: var(--blue);
            background-color: var(--blue);
            border-radius: 50%;
            font-size: 6px;
            margin-left: 6px;
        }

        .label-field-user,
        .label-field-client {
            display: flex;
            align-items: center;
        }

        .value-field-user,
        .value-field-client {
            flex: 1;
        }

        .note-field {
            color: gray;
        }

        .exit-pop-up-ads {
            display:none!important;
            position: absolute;
            /* border-radius: 20px; */
            border: 4px solid var(--blue);
            background-color: var(--bluePreHover);
            width: 60px;
            height: 60px;
            top: 20px;
            right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .exit-pop-up-ads:hover {
            background-color: var(--whitePostHover);
        }

        .exit-pop-up-ads i {
            font-size: 25px;
            font-weight: 700;
            color: var(--blue);
        }

        .btn-show-notification {
            display: none!important;
            cursor: pointer;
        position: fixed;
        font-size: 28px;
        color: var(--blue);
        border: 4px solid var(--blue);
        /* border-radius: 50%; */
        background-color: var(--bluePreHover);
        padding: 4px 18px;
        right: 100px;
        top: 20px;
            }

        .btn-show-notification:hover {
            background-color: var(--whitePostHover)
        }

        .symbol-unseen[data-is-seen='false'] {
            width: 15px;
            font-size: 11px;
            height: 15px;
            background: white;
            color: var(--blue);
            border: 2px solid var(--blue);
            border-radius: 50%;
            position: absolute;
            bottom: 32px;
            right: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }

        .symbol-unseen[data-is-seen='true'] {
            display: none;
        }
    </style>


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
    <div style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: flex-start;">
        <div class="card mb-0" style="width: 100%;">
            <div class="card-header d-flex">
                <h5>Infomation</h5>
            </div>
            <div class="card-body p-0" >
                <div class="row list-persons" id="addcon" style="display: flex; justify-content: center; align-items: flex-start;">
                    <div class="col-xl-8 xl-50 col-md-7">
                        <div class="tab-content ps-0" id="v-pills-tabContent">
                            <div class="tab-pane contact-tab-0 tab-content-child fade show active" id="v-pills-user"
                                role="tabpanel" aria-labelledby="v-pills-user-tab">
                                <div class="profile-mail">
                                    <div class="media">
                                    @if (isset($dataUser['pictureUrl']))
                                    <img class="img-100 img-fluid m-r-20 rounded-circle update_img_0"
                                            src="{{ $dataUser['pictureUrl'] }}" alt="">
                                        
                                    @else
                                    <img class="img-100 img-fluid m-r-20 rounded-circle update_img_0"
                                            src="https://store.kidbright.info/upload/cover-image/1544265083-nDP3ez.png" alt="">
                
                                    @endif
                                        
                                        <div class="media-body mt-0">
                                            <h5><span class="first_name_0">{{ $dataUser['displayName'] }}</span></h5>                                           
                                        </div>
                                    </div>
                                    <div class="email-general">
                                        <h6 class="mb-3">General</h6>
                                        <ul>
                                            <li>Name <span class="font-primary first_name_0">{{ $dataUser['displayName'] }}</span></li>
                                            <li>User ID<span class="font-primary mobile_num_0">{{ $dataUser['userId'] }}</span>
                                            </li>
                                            <li>Address Notification
                                                <span class="font-primary email_add_0">
                                                    {{ $dataUser['address'] }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-show-notification">
            <i class="fa-solid fa-bell"></i>
            @if ($announceCount > 0)
                <span class="symbol-unseen" data-is-seen='false'></span>
            @endif 
        </div>
        <div class="exit-pop-up-ads">
            <i class="fa-solid fa-right-from-bracket"></i>
        </div>
    </div>






    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script>
        let exitPopUpAds = document.querySelector('.exit-pop-up-ads');
        exitPopUpAds.addEventListener('click', (e) => {
            window.location.href = "/logout-user";
        });
        let btnShowNotification = document.querySelector('.btn-show-notification');
        btnShowNotification.addEventListener('click', (e) => {
            window.location.href = "/user/notify/list";
        });
    </script>
</body>

</html>
