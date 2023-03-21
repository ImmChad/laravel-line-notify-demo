@extends('Backend.backend-view')
@section('ContentAdmin')
    <style>
        .widget-joins .media .media-body svg {
            width: 30px;
            height: 30px;
        }
        .widget-joins .media {
            padding: 0px;
        }


        .widget-joins:after
        {
            height: 0px;
        }
        .files .file-box {
            cursor: pointer;
        }


        .txt-info {
            color: var(--theme-deafult) !important;
        }
    </style>


    <div class="container-fluid" id="test">
        <div class="row">
            <div class="col-xl-12 col-md-12 box-col-12">
                <div class="file-content">
                    <div class="card">
                        <div class="card-header">
                            <div class="media">
                                <form class="form-inline" action="#" method="get">
                                    <div class="form-group mb-0"> <i class="fa fa-search"></i>
                                        <input class="form-control-plaintext" type="text" placeholder="Search...">
                                    </div>
                                </form>
                                <div class="media-body text-end">
                                    <form class="d-inline-flex" action="#" method="POST" enctype="multipart/form-data"
                                        name="myForm">
                                        <div class="btn btn-primary btn-add-template">
                                            <i data-feather="plus-square"></i>
                                            Add Templates
                                        </div>
                                       
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body file-manager">
                            <h4 class="mb-3">All Templates</h4>
                            <h6>Click to open template.</h6>
                            <ul class="files">
                                @foreach ($dataTemplate as $subDataTemplate)
                                    <li class="file-box template-box" template_id="{{ $subDataTemplate->id }}">
                                        <div class="file-top div2"  id="test-display-image" style="overflow:hidden">
                                            <!-- <i class="fa fa-file-text-o txt-info"></i>
                                            <i class="fa fa-ellipsis-v f-14 ellips"></i> -->
                                            <div class="div1">
                                                {!! $subDataTemplate->template_content !!}
                                            </div>
                                        </div>
                                        <div class="file-bottom">
                                            <h6>{{ $subDataTemplate->template_name }}</h6>
                                            <p class="mb-1">0.90 KB</p>
                                            <p> <b>Created at: </b>{{ $subDataTemplate->created_at }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('script')
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon-clipart.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>


 



    <script>
        let div2 = document.querySelectorAll(".div2");
        div2.forEach(div_item=>{
            let div1 = div_item.querySelector(".div1");
            const scale = Math.min(div_item.offsetWidth / div1.offsetWidth, div_item.offsetHeight / div1.offsetHeight);
            div1.style.transform = `scale(${scale})`;
        })
        
        // div1.style.transformOrigin = "0 0";

    </script>

    <script>
        let btnAddTemplate = document.querySelector('.btn-add-template');
        btnAddTemplate.addEventListener('click', (e) => {
            window.location.href = "/admin/add-new-template-view";
        });


        let templateBox = document.querySelectorAll('.template-box');
        templateBox.forEach((item) => {
            item.addEventListener('click', (e)=> {
                let template_id = e.currentTarget.getAttribute('template_id');
                window.location.href = "/admin/update-template-view/" + template_id;
            });
        });


    </script>
   
   
@endsection
