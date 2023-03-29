@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins:after {
            height: 0px;

        }

        .content-send-notification {
            padding: 20px;
            margin-top: 40px;
            justify-content: space-between;
        }

        #btn-back-page {
            position: absolute;
            right: 10px;
            top: 10px;
            display: flex;
            justify-content: center;
            align-content: center;
            cursor: pointer;
            border-radius: 10px;
            padding: 10px;
            background: rgba(115, 102, 255, 0.08);
            color: #7366ff;
            width: max-content;
        }

        #btn-back-page {
            position: absolute;
            right: 10px;
            top: 10px;
            display: flex;
            justify-content: center;
            align-content: center;
            cursor: pointer;
            border-radius: 10px;
            padding: 10px;
            background: rgba(115, 102, 255, 0.08);
            color: #7366ff;
        }

        .section-select-type .dropdown {
            width: max-content;
        }

        .part-select-params {
            margin: 10px 0px;
            width: max-content;
        }

        .part-select-params .dropdown {
            width: max-content;
        }

        .part-select-params .dropdown-toggle {
            width: 100%;
            margin-right: 20px;
            min-width: 180px;
        }

        .section-template {

            position: relative;
        }

        .part-select-template {
            background: white;
            position: absolute;
            right: 10px;
            top: 10px;
            border-radius: 10px;
        }

        .section-select-type .dropdown-toggle, .part-select-template .dropdown-toggle {
            width: 100%;
            margin-right: 20px;
        }

        .part-preview-template .ipt-content-template {
            width: 100%;
            height: 100%;
            min-height: 300px;
            padding: 30px;
            resize: none;
            border-radius: .5rem;
            border: 3px solid var(--theme-deafult);
        }

        .part-preview-template .ipt-content-template::-webkit-scrollbar {
            display: none;
        }

        .section-option-others {
            margin: 10px 0px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .section-option-others .col {
            display: flex;
            flex-direction: column;
        }

        .btn-tick-send {
            border: 2px solid #51bb25;
            color: black;
        }

        .btn-tick-send:hover {
            border: 2px solid #51bb25 !important;
            background: #51bb25 !important;
            color: black;
        }

        .btn-send {
            border: 2px solid var(--theme-deafult);
            color: var(--theme-deafult);
        }

        .btn-send:hover {
            background: var(--theme-deafult);
            color: white;
        }

        .section-table-notification-draft {
            /*margin-bottom: 10px;*/
            /*max-height: 164px;*/
            /*overflow: auto;*/
        }

        .section-list-btn {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .section-preview-notification {
            width: max-content;
            max-width: 289px;
            height: max-content;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
            border-radius: 30px;
            min-height: 460px;
            margin-left: 20px;
            display: flex;
            justify-content: center;
            padding: 16px;
        }

        .section-table-notification-draft table td {
            text-align: right;
        }

        .header-section-table-notification-draft {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-section-table-notification-draft .comment-header {
            font-weight: bolder;
            font-style: italic;
            color: #a927f9;
        }

    </style>


    <div class="row"
         style="display: flex; justify-content: center; align-items: center; padding: 0rem 0rem !important; margin: 0px !important;">
        <div class="col" style="padding: 0px;">
            <div class="card height-equal">
                <div class="row content-send-notification">
                    <div id="btn-back-page">Back</div>
                    <div class="col-7 section-table-notification-draft">
                        <div class="header-section-table-notification-draft">
                            <h1 class="title-header">Your options</h1>
                            <span class="comment-header">Campaign check success!</span>
                        </div>
                        <table class="table">
                            <thead class="thead-dark">
                            </thead>
                            <tbody>
                                <tr class="template-box" draft_id="{{ $dataDraft->id }}">
                                    <th scope="row">Notification ID</th>
                                    <td>{{ $dataDraft->id }}</td>
                                </tr>
                                <tr class="template-box">
                                    <th scope="row">Notification For</th>
                                    <td>{{ $dataDraft->notification_for }}</td>
                                </tr>
                                <tr class="template-box">
                                    <th scope="row">Notification Title</th>
                                    <td>{{ $dataDraft->notification_title }}</td>
                                </tr>
                                <tr class="template-box">
                                    <th scope="row">Line user List will see</th>
                                    <td>{{ $dataDraft->line_user }}</td>
                                </tr>
                                <tr class="template-box">
                                    <th scope="row">Mail user List will see</th>
                                    <td>{{ $dataDraft->mail_user }}</td>
                                </tr>
                                <tr class="template-box">
                                    <th scope="row">SMS User List will see</th>
                                    <td>{{ $dataDraft->sms_user }}</td>
                                </tr>
                                <tr class="template-box">
                                    <th scope="row">Created at</th>
                                    <td>{{ $dataDraft->created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="section-list-btn">
                            <button type="button" class="btn btn-light">Cancel</button>
                            <button type="button" class="btn btn-info">Edit</button>
                            <button type="button" class="btn btn-primary">Send</button>
                        </div>
                    </div>

                    <div class="col-2 section-preview-notification">
                        <style>
                            @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400);

                            .container {
                                width: 400px;
                                padding: 10px;
                            }

                            .message-blue {
                                position: relative;
                                padding: 10px;
                                background-color: #A8DDFD;
                                width: 100%;
                                height: max-content;
                                text-align: left;
                                font: 400 0.9em 'Open Sans', sans-serif;
                                border: 1px solid #97C6E3;
                                border-radius: 0px 20px 20px 20px;
                            }

                            .message-content {
                                padding: 0;
                                margin: 0;
                            }



                        </style>
                        <div class="container">
                            <div class="message-blue">
                                <p class="message-content">{!! $dataDraft->notification_content !!}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('script')

@endsection




































