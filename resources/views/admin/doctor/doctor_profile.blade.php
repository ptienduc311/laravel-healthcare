@if (isset($doctor))
    <div class="col-md-4">
        <div class="ibox float-e-margins show-loading-bottom">
            <div class="ibox-title">
                <h5>Thông tin cá nhân</h5>
            </div>
            <div>
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-cube-grid">
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                    </div>
                    <div class="avatar-doctor">
                        <img alt="image" class="img-responsive" src="{{ $doctor->avatar_url }}">
                    </div>
                </div>
                <div class="ibox-content profile-content">
                    <div class="sk-spinner sk-spinner-cube-grid">
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                    </div>
                    <h3><strong>{{ $doctor->name }}</strong></h3>
                    <div class="my-3"><i class="fa fa-user-md"></i> Bác sĩ {{ $doctor->gender == 1 ? 'Nam' : 'Nữ' }}</div>
                    @if($doctor->address)
                        <div class="my-3"><i class="fa fa-location-arrow"></i> {{ $doctor->address }}</div>
                    @else
                        <div class="d-block my-3">
                            <i class="fa fa-location-arrow"></i> <p class="d-inline no-info">Chưa cập nhật.</p>
                        </div>
                    @endif
                    @if($doctor->email)
                        <div class="my-3"><i class="fa fa-envelope"></i> {{ $doctor->email }}</div>
                    @else
                        <div class="d-block my-3">
                            <i class="fa fa-envelope"></i> <p class="d-inline no-info">Chưa cập nhật.</p>
                        </div>
                    @endif
                    @if($doctor->phone)
                        <div class="my-3"><i class="fa fa-phone"></i> {{ $doctor->phone }}</div>
                    @else
                        <div class="d-block my-3">
                            <i class="fa fa-phone"></i> <p class="d-inline no-info">Chưa cập nhật.</p>
                        </div>
                    @endif
                    @if($doctor->current_workplace)
                        <div class="my-3"><i class="fa fa-hospital-o"></i> {{ $doctor->current_workplace }}</div>
                    @else
                        <div class="d-block my-3">
                            <i class="fa fa-hospital-o"></i> <p class="d-inline no-info">Chưa cập nhật.</p>
                        </div>
                    @endif
                    <a class="btn btn-primary" href="{{ route('doctor.edit', $doctor->id) }}" title="Cập nhật thông tin">Cập nhật</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="ibox float-e-margins show-loading-bottom">
            <div class="ibox-title">
                <h5>Thông tin chuyên ngành</h5>
            </div>
            <div class="ibox-content">
                <div class="sk-spinner sk-spinner-cube-grid">
                    <div class="sk-cube"></div>
                    <div class="sk-cube"></div>
                    <div class="sk-cube"></div>
                    <div class="sk-cube"></div>
                    <div class="sk-cube"></div>
                    <div class="sk-cube"></div>
                    <div class="sk-cube"></div>
                    <div class="sk-cube"></div>
                    <div class="sk-cube"></div>
                </div>
                <div class="feed-activity-list">
                    <div class="feed-element">
                        <div class="d-block">
                            <h4 class="d-inline-block">Chuyên khoa:</h4>
                            @if($doctor->specialty?->name)
                                <span>{{ $doctor->specialty?->name }}</span>
                            @else
                                <p class="d-inline no-info">Chưa cập nhật.</p>
                            @endif
                        </div>
                        <div class="d-block">
                            <h4 class="d-inline-block">Số năm kinh nghiệm:</h4>
                            @if($doctor->experience)
                                <span>{{ $doctor->experience }}</span>
                            @else
                                <p class="d-inline no-info">Chưa cập nhật.</p>
                            @endif
                        </div>
                        <div class="d-block">
                            <h4 class="d-inline-block">Học hàm:</h4>
                            @if(isset($academicTitles[$doctor->academic_title]))
                                <span>{{ $academicTitles[$doctor->academic_title] }}</span>
                            @else
                                <p class="d-inline no-info">Chưa cập nhật.</p>
                            @endif
                        </div>
                        <div class="d-block">
                            <h4 class="d-inline-block">Học vị:</h4>
                            @if(isset($degrees[$doctor->degree]))
                                <span>{{ $degrees[$doctor->degree] }}</span>
                            @else
                                <p class="d-inline no-info">Chưa cập nhật.</p>
                            @endif
                        </div>
                        <div class="d-block">
                            <h4 class="d-inline-block">Chức vụ:</h4>
                            @if($doctor->regency)
                                <span>{{ $doctor->regency }}</span>
                            @else
                                <p class="d-inline no-info">Chưa cập nhật.</p>
                            @endif
                        </div>
                    </div>
                    <div class="feed-element">
                        <h2 class="fw-semibold">Quá trình đào tạo</h2>
                        @if ($doctor->doctor_training->isNotEmpty())
                            <ul>
                                @foreach ($doctor->doctor_training as $item)
                                    <li>{{ $item->time_training ? $item->time_training . ': ' : '' }}{{ $item->content_training }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="no-info">Chưa cập nhật.</p>
                        @endif
                    </div>
                    <div class="feed-element">
                        <h2 class="fw-semibold">Quá trình làm việc</h2>
                        @if ($doctor->doctor_works->isNotEmpty())
                            <ul>
                                @foreach ($doctor->doctor_works as $item)
                                    <li>{{ $item->time_work ? $item->time_work . ': ' : '' }}{{ $item->content_work }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="no-info">Chưa cập nhật.</p>
                        @endif
                    </div>
                    <div class="feed-element">
                        <h2 class="fw-semibold">Giải thưởng ghi nhận</h2>
                        @if ($doctor->doctor_prizes->isNotEmpty())
                            <ul>
                                @foreach ($doctor->doctor_prizes as $item)
                                    <li>{{ $item->content_prize }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="no-info">Chưa cập nhật.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif