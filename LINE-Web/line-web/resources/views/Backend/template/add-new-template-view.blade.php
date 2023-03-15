

@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins:after {
            height: 0px;
        }
    </style>

    <div class="row">

        <div class="col-xl-3 col-md-6 box-col-6">
            <div class="email-left-aside">
                <div class="card">
                    <div class="card-body" style="padding: 0px;">
                        <div class="email-app-sidebar">
                            <div class="media">
                                <div class="media-body">
                                <div class="mb-3">
                                    <label for="exampleInputName">Notification Name</label>
                                    <input class="form-control" id="template_name" type="text" placeholder="Enter title ...">
                                </div>
                                </div>
                            </div>
                            <ul class="nav main-menu" role="tablist" style="padding: 1rem; display: flex; flex-wrap: wrap;">
                                <li class="nav-item" style="padding: 1rem 0rem; width: 100%; color: white; background: var(--theme-deafult);">
                                    <a class="show" style=" color: white; padding: 0.5rem;" id="pills-darkhome-tab"
                                        data-bs-toggle="pill" href="#pills-darkhome" role="tab"
                                        aria-controls="pills-darkhome" aria-selected="true" >
                                        <i class="icofont icofont-at"></i>
                                        For Title
                                    </a>
                                </li>
                                <li style="padding: 1rem 0rem; width: 100%;">
                                    <select class="form-select digits" id="dataRegion">
                                            <option region_id="0" region_name="null">Choose Region</option>
                                        @foreach ($dataRegion as $subDataRegion)
                                            <option region_id="{{ $subDataRegion->id }}" region_name="{{ $subDataRegion->region_name }}">{{ $subDataRegion->region_name }}</option>
                                        @endforeach
									</select>
                                </li>
                                <li style="padding: 1rem 0rem; width: 100%;">
                                    <hr>
                                </li style="padding: 1rem 0rem; width: 100%;">
                                <li class="nav-item" style="padding: 1rem 0rem; width: 100%; color: white; background: var(--theme-deafult);">
                                    <a class="show" style=" color: white; padding: 0.5rem;" id="pills-darkhome-tab"
                                        data-bs-toggle="pill" href="#pills-darkhome" role="tab"
                                        aria-controls="pills-darkhome" aria-selected="true" >
                                        <i class="icofont icofont-at"></i>
                                        For Content
                                    </a>
                                </li>
                                <li style="padding: 1rem 0rem; width: 100%;">
                                    <select class="form-select digits" id="dataArea">
                                        <option area_id="0" area_name="null">Choose Area</option>
                                        @foreach ($dataArea as $subDataArea)
                                            <option area_id="{{ $subDataArea->id }}" area_name="{{ $subDataArea->area_name }}">{{ $subDataArea->area_name }}</option>
                                        @endforeach
                                    </select>
                                </li>
                                <li style="padding: 1rem 0rem; width: 100%;">
                                    <select class="form-select digits" id="dataIndustry">
                                        <option industry_id="0" industry_name="null">Choose Industry</option>
                                        @foreach ($dataIndustry as $subDataIndustry)
                                            <option industry_id="{{ $subDataIndustry->id }}" industry_name="{{ $subDataIndustry->industry_name }}">{{ $subDataIndustry->industry_name }}</option>
                                        @endforeach
                                    </select>
                                </li>
                                <li style="padding: 1rem 0rem; width: 100%;">
                                    <select class="form-select digits" id="dataStore">
                                        <option store_id="0" store_name="null">Choose Store</option>
                                        @foreach ($dataStore as $subDataStore)
                                            <option store_id="{{ $subDataStore->id }}" store_name="{{ $subDataStore->store_name }}">{{ $subDataStore->store_name }}</option>
                                        @endforeach
                                    </select>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-md-12 box-col-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h5>Template</h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li class="template-management"><i data-feather="corner-down-left"
                                    style="cursor: pointer;"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="contact-form card-body">
                    <form class="theme-form">
                        <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                        <div class="mb-3">
                            <label for="exampleInputName">Notification title</label>
                            <input class="form-control" id="announce_title" type="text" placeholder="Enter title ...">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="exampleInputEmail1">Notification content</label>

                            <textarea class="form-control textarea" id="announce_content" rows="3" cols="50"
                                placeholder="Your Message"></textarea>
                        </div>
                        <div class="text-sm-end">
                            <button id="btn-submit-add-template" class="btn btn-primary-gradien btn-send-it">ADD TEMPLATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{asset('assets/js/editor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/js/editor/ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{asset('assets/js/email-app.js')}}"></script>

    <script >

        // CKEDITOR.on('instanceReady', function(){ 
        //     var announce_content = CKEDITOR.instances['announce_content'];
        //     announce_content.insertHtml(`<div style="display:flex"></div>`);
        // }); 

        let dataRegion = document.querySelector('#dataRegion');
        dataRegion.addEventListener('change', (e) => {
            let region_id = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('region_id');
            let region_name = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('region_name');

            let announce_title = document.querySelector('#announce_title');

            if(region_id != 0) {
                announce_title.value += `[${region_name}]`;
            }
        })

        let dataArea = document.querySelector('#dataArea');
        dataArea.addEventListener('change', (e) => {
            let area_id = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('area_id');
            let area_name = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('area_name');

            // let announce_title = document.querySelector('#announce_title');
            var announce_content = CKEDITOR.instances['announce_content'];
            var dataArea = announce_content.document.findOne('#dataArea');

            if(area_id != 0) {
                if(dataArea != null ) {
                    dataArea.setHtml('['+ area_name +']');
                } else {
                    let newDiv = '<p id="dataArea">[' + area_name + ']</p <p>&nbsp;</p>';
                    // Thêm thẻ div mới vào bên trong thẻ div đỏ
                    announce_content.insertHtml(newDiv);
                }
            }
        })

        let dataIndustry = document.querySelector('#dataIndustry');
        dataIndustry.addEventListener('change', (e) => {
            let industry_id = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('industry_id');
            let industry_name = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('industry_name');

            // let announce_title = document.querySelector('#announce_title');
            var announce_content = CKEDITOR.instances['announce_content'];
            var dataIndustry = announce_content.document.findOne('#dataIndustry');

            if(industry_id != 0) {
                if(dataIndustry != null ) {
                    dataIndustry.setHtml('['+ industry_name +']');
                } else {
                    let newDiv = '<div id="dataIndustry">[' + industry_name + ']</div><p>&nbsp;</p>';
                    // Thêm thẻ div mới vào bên trong thẻ div đỏ
                    announce_content.insertHtml(newDiv);
                }
            }
        });

        let dataStore = document.querySelector('#dataStore');
        dataStore.addEventListener('change', (e) => {
            let store_id = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('store_id');
            let store_name = e.currentTarget.options[e.currentTarget.selectedIndex].getAttribute('store_name');

            // let announce_title = document.querySelector('#announce_title');
            var announce_content = CKEDITOR.instances['announce_content'];
            var dataStore = announce_content.document.findOne('#dataStore');

            if(store_id != 0) {
                if(dataStore != null ) {
                    dataStore.setHtml('['+ store_name +']');
                } else {
                    let newDiv = '<div id="dataStore">[' + store_name + ']</div><p>&nbsp;</p>';
                    // Thêm thẻ div mới vào bên trong thẻ div đỏ
                    announce_content.insertHtml(newDiv);
                }
            }
        });





        // event return 
        let returnNotificationList = document.querySelector('.template-management');
        returnNotificationList.addEventListener('click', (e)=>{
            window.location.href = "/admin/template-management";
        });


        var btn_add_template = document.querySelector("#btn-submit-add-template");

        btn_add_template.addEventListener('click',(event)=>{
            event.preventDefault()
            let dataRegion = document.querySelector('#dataRegion');
            let dataArea = document.querySelector('#dataArea');
            let dataStore = document.querySelector('#dataStore');
            var dataIndustry = document.querySelector('#dataIndustry');
            var announce_content = CKEDITOR.instances['announce_content'];
            var announce_title = document.querySelector('#announce_title');
            var template_name = document.querySelector('#template_name').value;
            var template_content = announce_content.getData()
            var template_title = announce_title.value;
            var region_id= dataRegion.options[dataRegion.selectedIndex].getAttribute('region_id');
            var area_id= dataArea.options[dataArea.selectedIndex].getAttribute('area_id');
            var industry_id= dataIndustry.options[dataIndustry.selectedIndex].getAttribute('industry_id');
            var store_id= dataStore.options[dataStore.selectedIndex].getAttribute('store_id');
            reqAddTemplate(
            template_name,
            template_title,
            template_content,
            region_id,
            area_id,
            industry_id,
            store_id,
        )
        })


        function reqAddTemplate(
            template_name,
            template_title,
            template_content,
            region_id=null,
            area_id=null,
            industry_id=null,
            store_id=null,
        ) {
                if(template_name.length>0 && template_title.length>0 && template_content.length>0)
                {
                    var form  = new FormData();
                    form.append('template_name',template_name);
                    form.append('template_title',template_title);
                    form.append('template_content',template_content);
                    form.append('region_id',region_id);
                    form.append('area_id',area_id);
                    form.append('industry_id',industry_id);
                    form.append('store_id',store_id);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{URL::to("admin/add-template")}}',
                        method: 'post',
                        data: form,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            if(data.result)
                            {
                                displayToast("Successfully add new template ")
                                location.href="/admin/add-new-template-view"
                            }
                            else
                            {

                            }
                        },
                        error: function() {
                        }
                    });
                }  
                else
                {
                    displayToast("Please fill in full")
                }  
        } 
    </script>
@endsection
