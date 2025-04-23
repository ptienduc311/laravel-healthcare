@extends('layouts.admin')

@section('title', 'Danh sách danh mục')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Chuyên khoa y tế</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Chuyên khoa y tế</a>
            </li>
            <li class="active">
                <strong>Trang chuyên khoa</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" id="keyword" placeholder="Nhập tên chuyên khoa" class="input-sm form-control">
                            <ul class="list-group clear-list m-t" id="specialty-list">
                                @foreach ($medical_specialties as $key=>$item)
                                    <li class="speacialty-item d-flex justify-content-between align-items-center list-group-item{{$key == 0 ? " fist-item" : ""}}" data-id="{{$item->id}}">
                                        <span>{{$item->name}}</span>
                                        <div class="pull-right">
                                            <button class="btn {{$item->status == 1 ? "btn-primary" : "btn-danger" }} btn-circle" type="button">
                                                <i class="fa {{$item->status == 1 ? "fa-check" : "fa-times" }}"></i>
                                            </button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8" style="">
            <div class="ibox float-e-margins">
                <div class="ibox-content" style="position: relative;">
                    <h3 class="ngRow mb-5 pb-3 d-block fw-bold" id="name_specialty"></h3>
                    <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="">
                        <div class="modal-dialog">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('medical-specialty.info-page-handle') }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Đoạn mô tả</label>
                            <div class="col-sm-10">
                                <textarea class="form-control message-input" name="description" id="description"></textarea>
                                @error('title')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ảnh đoạn mô tả</label>
                            <div class="col-sm-10">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div>
                                      <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Chọn ảnh</span>
                                        <span class="fileinput-exists">Thay đổi</span>
                                        <input type="file" name="image" accept="image/*">
                                      </span>
                                      <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                    </div>
                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 200px; border:none;line-height: 200px;"></div>
                                    @error('image')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Dịch vụ chính</label>
                            <div class="col-sm-10" id="main-service">
                                <div class="main-service-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 me-1">
                                            <input type="text" class="form-control mb-3" name="name_service[]" value="" placeholder="Tên dịch vụ">
                                            <input type="text" class="form-control" name="description_service[]" value="" placeholder="Mô tả dịch vụ">
                                        </div>
                                        <button class="btn btn-danger btn-circle btn-remove-service-item" type="button">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="hr-line-normal"></div>
                                </div>
                                <button class="btn btn-info btn-circle btn-add-service-item" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Cơ sở vật chất - Trang thiết bị</label>
                            <div class="col-sm-10">
                                <textarea id="editor" name="content"></textarea>
                                @error('content')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="specialty_id" id="specialty_id" value="">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary disabled" type="submit">Tinh chỉnh</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    @if (session('status'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "10000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.success("{{session('status')}}")
        </script>
    @endif
    @if (session('error'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "10000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.error("{{session('error')}}")
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //Ảnh
            const fileinput = document.querySelector('.fileinput');
    
            const preview = fileinput.querySelector('.fileinput-preview');
    
            const updatePreviewVisibility = () => {
                if (fileinput.classList.contains('fileinput-exists')) {
                preview.style.display = 'block';
                } else {
                preview.style.display = 'none';
                }
            };
    
            updatePreviewVisibility();
    
            const observer = new MutationObserver(updatePreviewVisibility);
            observer.observe(fileinput, { attributes: true, attributeFilter: ['class'] });
        });

        $(document).ready(function(){
            //Tìm kiếm dịch vụ
            $("#keyword").on("input", function() {
                let keyword = $(this).val();
                $.ajax({
                    url: '{{ route("medical-specialty.search") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: { 
                        keyword: keyword,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#specialty-list").html(response.html);
                    }
                });
            });

            //disabled submit form
            $(".form-horizontal").on("submit", function(event) {
                if ($("button[type='submit']").hasClass("disabled")) {
                    event.preventDefault(); // Chặn form nếu button đang bị disabled
                }
            });
        });

        //Render dịch vụ
        function renderServiceItem(name = '', description = '') {
            return `
                <div class="main-service-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 me-1">
                            <input type="text" class="form-control mb-3" name="name_service[]" value="${name}" placeholder="Tên dịch vụ">
                            <input type="text" class="form-control" name="description_service[]" value="${description}" placeholder="Mô tả dịch vụ">
                        </div>
                        <button class="btn btn-danger btn-circle btn-remove-service-item" type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <div class="hr-line-normal"></div>
                </div>
            `;
        }


        //Thêm dịch vụ
        $(document).on('click', '.btn-add-service-item', function () {
            $(this).before(renderServiceItem());
        });

        //Xóa dịch vụ
        $(document).on('click', '.btn-remove-service-item', function () {
            $(this).closest('.main-service-item').remove();
        });

        //Click dịch vụ
        $(document).on('click', '.speacialty-item', function () {
            const service_id = $(this).data('id');
            $.ajax({
                url: '{{ route("medical-specialty.select-service-handle") }}',
                method: 'POST',
                dataType: 'json',
                data: { 
                    service_id: service_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response.result)
                    $("#name_specialty").text('');
                    $("#specialty_id").val('');
                    $("#description").val('');
                    editor.setData('');
                    $('#main-service .main-service-item').remove();
                    $('.btn-add-service-item').before(renderServiceItem());

                    const $fileInputWrapper = $('.fileinput');
                    $fileInputWrapper
                        .removeClass('fileinput-exists')
                        .addClass('fileinput-new');
                    $fileInputWrapper.find('.fileinput-preview')
                        .empty()
                        .hide();

                    if(response.result.page_specialty){
                        $("#description").val(response.result.page_specialty.description || '');
                        editor.setData(response.result.page_specialty.content || '');
                    }

                    if(response.result.service_id){
                        $("#specialty_id").val(response.result.service_id);
                    }

                    if(response.result.name){
                        $("#name_specialty").text(response.result.name);
                    }

                    if (response.result.image) {
                        $fileInputWrapper
                            .removeClass('fileinput-new')
                            .addClass('fileinput-exists');

                        const imageUrl = `{{ Storage::url('') }}` + response.result.image;
                        const imageTag = `<img src="${imageUrl}" alt="Ảnh bìa" style="max-width: 100%; max-height: 100%;">`;

                        $fileInputWrapper.find('.fileinput-preview')
                            .html(imageTag)
                            .css('display', 'block');
                    }

                    if(response.result.services){
                        $('#main-service .main-service-item').remove();
                        response.result.services.forEach(service => {
                            $('.btn-add-service-item').before(renderServiceItem(service.name, service.description));
                        });
                    }
                }
            });
        });

    </script>
@endsection