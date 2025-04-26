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
                                    <li class="specialty-item px-2 d-flex justify-content-between align-items-center list-group-item{{$key == 0 ? " fist-item" : ""}}" data-id="{{$item->id}}">
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
                <div class="ibox-content relative">
                    <div class="overlay"></div>
                    <div class="spiner-example loading">
                        <div class="sk-spinner sk-spinner-wave">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                    </div>
                    <h3 class="ngRow mb-5 pb-3 d-block fw-bold" id="name_specialty">
                        <i class="fw-semibold">Chọn chuyên khoa</i>
                    </h3>
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
                        <div class="form-group dynamic-group" data-container="#main-service" data-item=".main-service-item">
                            <label class="col-sm-2 control-label">Dịch vụ chính</label>
                            <div class="col-sm-10" id="main-service">
                                @php
                                    $nameService = old('name_service', ['']);
                                    $descriptionService = old('description_service', ['']);
                                @endphp
                                @foreach ($nameService as $i => $name)
                                    <div class="main-service-item dynamic-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1 me-1">
                                                <input type="text" class="form-control mb-3" name="name_service[]" placeholder="Tên dịch vụ" value="{{ $name }}">
                                                <input type="text" class="form-control" name="description_service[]" placeholder="Mô tả dịch vụ" value="{{ $descriptionService[$i] ?? '' }}">   
                                            </div>
                                            <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="hr-line-normal"></div>
                                    </div>
                                @endforeach
                                <button class="btn btn-info btn-circle btn-add btn-add-service-item" type="button">
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
                        <input type="hidden" name="remove_image" value="0" id="remove-image-flag">
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
    @if (session('success'))
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

            toastr.success("{{session('success')}}")
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
        $(document).ready(function(){
            //Tìm kiếm chuyên khoa
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

            const $form = $(".form-horizontal");
            const $submitBtn = $form.find("button[type='submit']");
            $form.on("submit", function (event) {
                if ($submitBtn.hasClass("disabled")) {
                    event.preventDefault();
                    return;
                }
        
                let hasError = false;
                $(".main-service-item .error").remove();
        
                $(".main-service-item").each(function () {
                    const $item = $(this);
                    const $nameInput = $item.find("input[name='name_service[]']");
                    const $descInput = $item.find("input[name='description_service[]']");
                    const name = $nameInput.val().trim();
                    const desc = $descInput.val().trim();
        
                    if ((name && !desc) || (!name && desc)) {
                        hasError = true;
        
                        const errorMsg = name
                            ? "Vui lòng nhập mô tả dịch vụ."
                            : "Vui lòng nhập tên dịch vụ.";
        
                        $item.append(`<p class="error mb-3 mt-0 text-danger">${errorMsg}</p>`);
                    }
                });
        
                if (hasError) {
                    event.preventDefault();
                }
            });
        
            // Xử lý khi người dùng gõ lại => kiểm tra lại lỗi
            $(document).on("input", "input[name='name_service[]'], input[name='description_service[]']", function () {
                const $item = $(this).closest(".main-service-item");
                const name = $item.find("input[name='name_service[]']").val().trim();
                const desc = $item.find("input[name='description_service[]']").val().trim();
        
                const $error = $item.find(".error");
                if ((name && desc) && $error.length) {
                    $error.remove();
                } else if ((!name && !desc) && !$error.length) {
                    return;
                } else if ((name && !desc || !name && desc) && !$error.length) {
                    const errorMsg = name
                        ? "Vui lòng nhập mô tả dịch vụ."
                        : "Vui lòng nhập tên dịch vụ.";
                    $item.append(`<p class="error mb-3 mt-0 text-danger">${errorMsg}</p>`);
                }
            });
        });

        //Render dịch vụ
        function renderServiceItem(name = '', description = '') {
            return `
                <div class="main-service-item dynamic-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1 me-1">
                            <input type="text" class="form-control mb-3" name="name_service[]" placeholder="Tên dịch vụ" value="${name}">
                            <input type="text" class="form-control" name="description_service[]" placeholder="Mô tả dịch vụ" value="${description}">   
                        </div>
                        <button class="btn btn-danger btn-circle btn-remove" type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <div class="hr-line-normal"></div>
                </div>
            `;
        }

        //Click chuyên khoa
        $(document).on('click', '.specialty-item', function () {
            const $this = $(this);
            if ($this.hasClass('disabled')) return;
            
            const service_id = $(this).data('id');

            $('.specialty-item').addClass('disabled').css('pointer-events', 'none');
            $('.specialty-item').css('background-color', '');
            $(this).css('background-color', '#e7e7e7');

            const $ibox = $('.ibox-content');
            $ibox.addClass('active');
            $ibox.find(':input, button, a').addClass('disabled').css('pointer-events', 'none');
            $ibox.css('cursor', 'not-allowed');

            $("#name_specialty").html('<i class="fw-semibold">Chọn chuyên khoa</i>');

            setTimeout(function () {
                $.ajax({
                    url: '{{ route("medical-specialty.select-service-handle") }}',
                    method: 'POST',
                    dataType: 'json',
                    data: { 
                        service_id: service_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('.ibox-content').removeClass('active');
                        $("#name_specialty").html('');
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

                        $('.specialty-item').removeClass('disabled').css('pointer-events', '');
                        $ibox.removeClass('active');
                        $ibox.find(':input, button, a').removeClass('disabled').css('pointer-events', '');
                        $ibox.css('cursor', '');
                    },
                    error: function(xhr, status, error) {
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "progressBar": false,
                            "preventDuplicates": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "400",
                            "hideDuration": "1000",
                            "timeOut": "4000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.error("Có lỗi xảy ra", "Vui lòng thử lại!")
                        
                        $('.specialty-item').removeClass('disabled').css('pointer-events', '');
                        $ibox.removeClass('active');
                        $ibox.find(':input, button, a').removeClass('disabled').css('pointer-events', '');
                        $ibox.css('cursor', '');
                    }
                });
            }, 1500);
        });
    </script>
@endsection