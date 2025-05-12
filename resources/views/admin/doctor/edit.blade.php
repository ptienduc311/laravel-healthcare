@extends('layouts.admin')

@section('title', 'Cập nhật bác sĩ')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Bác sĩ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Bác sĩ</a>
            </li>
            <li class="active">
                <strong>Cập nhật bác sĩ</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('doctor.update', $doctor->id) }}" autocomplete="off">
                @csrf
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thông tin chuyên khoa</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tên bác sĩ<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ $doctor->name }}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ảnh đai diện</label>
                            <div class="col-sm-10">
                                <div class="fileinput {{ !empty($doctor->image_id) ? "fileinput-exists" : "fileinput-new"}}" data-provides="fileinput">
                                    <div>
                                      <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Chọn ảnh</span>
                                        <span class="fileinput-exists">Thay đổi</span>
                                        <input type="file" name="avatar" accept="image/*">
                                      </span>
                                      <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                    </div>
                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="{{ !empty($doctor->image_id) ? 'display: block;' : ''}}width: 200px; height: 200px; border:none;">
                                        @if($doctor->image_id)
                                            <img src="{{ Storage::url($doctor->image->src) }}" alt="Ảnh bìa" style="max-width: 100%; max-height: 100%;">
                                        @endif
                                    </div>
                                    @error('avatar')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="remove_image" value="0" class="remove-image-flag">
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="gender">Giới tính<span class="claim">*</span></label>
                            <div class="col-sm-10 mt-2">
                                <div class="radio radio-danger radio-inline pt-0">
                                    <input type="radio" id="male" value="1" name="gender"{{ $doctor->gender == 1 ? " checked" : "" }}>
                                    <label for="male">Nam</label>
                                </div>
                                <div class="radio radio-info radio-inline pt-0">
                                    <input type="radio" id="female" value="2" name="gender"{{ $doctor->gender == 2 ? " checked" : "" }}>
                                    <label for="female">Nữ</label>
                                </div>
                                @error('gender')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Chuyên khoa</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" name="specialty_id">
                                    <option value="">Chọn chuyên khoa</option>
                                    @foreach ($specialties as $item)
                                        <option value="{{ $item->id }}" {{ $doctor->specialty_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('specialty_id')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Số năm kinh nghiệm</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="experience" value="{{ $doctor->experience }}">
                                @error('experience')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Học hàm</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" name="academic_title">
                                    <option value="">Chọn học hàm</option>
                                    <option value="1" {{ $doctor->academic_title == 1 ? 'selected' : '' }}>Giáo sư</option>
                                    <option value="2" {{ $doctor->academic_title == 2 ? 'selected' : '' }}>Phó giáo sư</option>
                                </select>
                                @error('academic_title')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Học vị</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" name="degree">
                                    <option value="">Chọn học vị</option>
                                    <option value="1" {{ $doctor->degree == 1 ? 'selected' : '' }}>Bác sĩ nội trú</option>
                                    <option value="2" {{ $doctor->degree == 2 ? 'selected' : '' }}>Bác sĩ</option>
                                    <option value="3" {{ $doctor->degree == 3 ? 'selected' : '' }}>Tiến sĩ</option>
                                    <option value="4" {{ $doctor->degree == 4 ? 'selected' : '' }}>Thạc sĩ</option>
                                    <option value="5" {{ $doctor->degree == 5 ? 'selected' : '' }}>Bác sĩ chuyên khoa II</option>
                                    <option value="6" {{ $doctor->degree == 6 ? 'selected' : '' }}>Bác sĩ chuyên khoa I</option>
                                    <option value="7" {{ $doctor->degree == 7 ? 'selected' : '' }}>Bác sĩ cao cấp</option>
                                </select>
                                @error('degree')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Chức vụ</label>
                            <div class="col-sm-10">
                                <textarea class="form-control message-input" name="regency" id="regency">{{ $doctor->regency }}</textarea>
                                @error('regency')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Giới thiệu bác sĩ</label>
                            <div class="col-sm-10">
                                <textarea id="editor" name="introduce">{{ $doctor->introduce }}</textarea>
                                @error('introduce')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <!-- Training process -->
                        <div class="form-group dynamic-group" data-container="#training-process" data-item=".training-process-item">
                            <label class="col-sm-2 control-label">Quá trình đào tạo</label>
                            <div class="col-sm-10" id="training-process">
                                @php
                                    $hasOld = count(request()->old()) > 0;
                                    $oldTimeTraining = old('time_training_process', ['']);
                                    $oldContentTraining = old('content_training_process', ['']);
                                    $hasDoctorTraining = !empty($doctor->doctor_training) && count($doctor->doctor_training) > 0;
                                @endphp
                                @if ($hasOld)
                                    @foreach ($oldTimeTraining as $i => $time)
                                        <div class="training-process-item dynamic-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1 me-4 mb-3 d-flex align-items-center">
                                                    <input type="text" class="form-control w-25 me-2" name="time_training_process[]" placeholder="Thời gian đào tạo" value="{{ $time }}">
                                                    <input type="text" class="form-control w-75" name="content_training_process[]" placeholder="Nội dung đào tạo" value="{{ $oldContentTraining[$i] }}">
                                                </div>
                                                <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            @error("training_process.$i")
                                                <p class="error mb-3 mt-0">{{ $message }}</p>
                                            @enderror
                                            <div class="hr-line-normal"></div>
                                        </div>
                                    @endforeach
                                @elseif ($hasDoctorTraining)
                                    @foreach ($doctor->doctor_training as $training)
                                        <div class="training-process-item dynamic-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1 me-4 mb-3 d-flex align-items-center">
                                                    <input type="text" class="form-control w-25 me-2" name="time_training_process[]" placeholder="Thời gian đào tạo" value="{{ $training->time_training }}">
                                                    <input type="text" class="form-control w-75" name="content_training_process[]" placeholder="Nội dung đào tạo" value="{{ $training->content_training }}">
                                                </div>
                                                <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="hr-line-normal"></div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="training-process-item dynamic-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1 me-4 mb-3 d-flex align-items-center">
                                                <input type="text" class="form-control w-25 me-2" name="time_training_process[]" placeholder="Thời gian đào tạo">
                                                <input type="text" class="form-control w-75" name="content_training_process[]" placeholder="Nội dung đào tạo">
                                            </div>
                                            <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="hr-line-normal"></div>
                                    </div>
                                @endif
                                <button class="btn btn-info btn-circle btn-add" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Work process -->
                        <div class="form-group dynamic-group" data-container="#work-process" data-item=".work-process-item">
                            <label class="col-sm-2 control-label">Quá trình công tác</label>
                            <div class="col-sm-10" id="work-process">
                                @php
                                    $oldTimeWork = old('time_work_process', ['']);
                                    $oldContentWork = old('content_work_process', ['']);
                                    $hasDoctorWork = !empty($doctor->doctor_works) && count($doctor->doctor_works) > 0;
                                @endphp
                                @if ($hasOld)
                                    @foreach ($oldTimeWork as $i => $time)
                                        <div class="work-process-item dynamic-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1 me-4 mb-3 d-flex align-items-center">
                                                    <input type="text" class="form-control w-25 me-2" name="time_work_process[]" placeholder="Thời gian công tác" value="{{ $time }}">
                                                    <input type="text" class="form-control w-75" name="content_work_process[]" placeholder="Nội dung công tác" value="{{ $oldContentWork[$i] }}">
                                                </div>
                                                <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            @error("work_process.$i")
                                                <p class="error mb-3 mt-0">{{ $message }}</p>
                                            @enderror
                                            <div class="hr-line-normal"></div>
                                        </div>
                                    @endforeach
                                @elseif ($hasDoctorWork)
                                    @foreach ($doctor->doctor_works as $work)
                                        <div class="work-process-item dynamic-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1 me-4 mb-3 d-flex align-items-center">
                                                    <input type="text" class="form-control w-25 me-2" name="time_work_process[]" placeholder="Thời gian công tác" value="{{ $work->time_work }}">
                                                    <input type="text" class="form-control w-75" name="content_work_process[]" placeholder="Nội dung công tác" value="{{ $work->content_work }}">
                                                </div>
                                                <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="hr-line-normal"></div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="work-process-item dynamic-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1 me-4 mb-3 d-flex align-items-center">
                                                <input type="text" class="form-control w-25 me-2" name="time_work_process[]" placeholder="Thời gian công tác">
                                                <input type="text" class="form-control w-75" name="content_work_process[]" placeholder="Nội dung công tác">   
                                            </div>
                                            <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="hr-line-normal"></div>
                                    </div>
                                @endif
                                <button class="btn btn-info btn-circle btn-add" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Prize -->
                        <div class="form-group dynamic-group" data-container="#prize" data-item=".prize-item">
                            <label class="col-sm-2 control-label">Giải thưởng, ghi nhận</label>
                            <div class="col-sm-10" id="prize">
                                @php
                                    $oldContentPrize = old('content_prize', ['']);
                                    $hasDoctorPrize = !empty($doctor->doctor_prizes) && count($doctor->doctor_prizes) > 0;
                                @endphp
                                @if ($hasOld)
                                    @foreach ($oldContentPrize as $i => $content)
                                        <div class="prize-item dynamic-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1 me-4">
                                                    <input type="text" class="form-control mb-3" name="content_prize[]" placeholder="Nội dung giải thưởng" value="{{ $content }}">
                                                </div>
                                                <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="hr-line-normal"></div>
                                        </div>
                                    @endforeach
                                @elseif ($hasDoctorPrize)
                                    @foreach ($doctor->doctor_prizes as $i => $prize)
                                        <div class="prize-item dynamic-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1 me-4">
                                                    <input type="text" class="form-control mb-3" name="content_prize[]" placeholder="Nội dung giải thưởng" value="{{ $prize->content_prize }}">
                                                </div>
                                                <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="hr-line-normal"></div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="prize-item dynamic-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1 me-4">
                                                <input type="text" class="form-control mb-3" name="content_prize[]" placeholder="Nội dung giải thưởng">
                                            </div>
                                            <button class="btn btn-danger btn-circle btn-remove" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="hr-line-normal"></div>
                                    </div>
                                @endif
                                <button class="btn btn-info btn-circle btn-add" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="is_outstanding">Bác sĩ nổi bật</label>
                            <div class="col-sm-10 mt-2">
                                <div class="checkbox checkbox-danger pt-0">
                                    <input id="is_outstanding" type="checkbox" name="is_outstanding" {{ $doctor->is_outstanding == 1 ? 'checked' : '' }}>
                                    <label></label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Trạng thái</label>
                            <div class="col-sm-10 mt-2">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status" {{ $doctor->status == 1 ? 'checked' : '' }}>
                                        <label class="onoffswitch-label" for="status">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thông tin cá nhân <small>(không bắt buộc)</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Địa chỉ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="address" value="{{ $doctor->address }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" value="{{ old('email', $doctor->email) }}">
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Số điện thoại</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone" value="{{ $doctor->phone }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nơi công tác</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="current_workplace" value="{{ $doctor->current_workplace }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection