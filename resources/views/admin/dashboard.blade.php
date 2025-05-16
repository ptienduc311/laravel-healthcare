@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-danger">
                        <h5>Chuyên khoa</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $medicalSpecialtyCount }}</h1>
                        <small>chuyên khoa</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-primary">
                        <h5>Bác sĩ</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $doctorCount }}</h1>
                        <small>bác sĩ</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-info">
                        <span class="label label-warning pull-right">Hôm nay</span>
                        <h5>Số lịch khám</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $appointmentsTodayFormatted }}</h1>
                        <small>lịch khám</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-success">
                        <span class="label label-danger pull-right">Tháng {{ $thisMonth }}</span>
                        <h5>Số lịch khám</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $appointmentsThisMonthFormatted }}</h1>
                        <small>lịch khám</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-info">
                        <span class="label label-warning pull-right">Hôm nay</span>
                        <h5>Số lịch hẹn</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $booksTodayFormatted }}</h1>
                        <small>lịch hẹn</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-success">
                        <span class="label label-danger pull-right">Tháng {{ $thisMonth }}</span>
                        <h5>Số lịch hẹn</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $booksThisMonthFormatted }}</h1>
                        <small>lịch hẹn</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lịch hẹn</h5>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ request()->fullUrlWithQuery(['type' => 'day']) }}" class="btn btn-xs btn-white {{ request('type') == 'day' ? 'active' : '' }}">Hôm nay</a>
                                <a href="{{ request()->fullUrlWithQuery(['type' => 'month']) }}" class="btn btn-xs btn-white {{ request('type') == 'month' ? 'active' : '' }}">Tháng {{ $thisMonth }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Mã hẹn</th>
                                                <th>Tên bệnh nhân</th>
                                                <th>Thời gian khám</th>
                                                <th>Bác sĩ</th>
                                                <th>Trạng thái</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listBooks as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->book_code }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td><strong>{{ $item->appointment ? $item->appointment->hour_examination . ' - ' : '' }}{{ $item->date_examination }}</strong></td>
                                                    <td>{{ $item->doctor?->name }}{{ $item->specialty_id ? ' - ' . $item->specialty?->name : '' }}</td>
                                                    @php
                                                        $status = $statusMap[$item->status] ?? ['name' => 'Không rõ', 'color' => 'dark'];
                                                    @endphp
                                                    <td><span class="fw-semibold text-{{ $status['color'] }}">{{ $status['name'] }}</span></td>
                                                    <td><a href="{{ route('book.show', $item->id) }}"><i class="fa fa-eye text-navy"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{$listBooks->links()}}
                            </div>
                            <div class="col-lg-2">
                                <ul class="stat-list">
                                    @foreach ($statusMap as $key => $status)
                                        @php
                                            $count = $statusCount[$key] ?? 0;
                                        @endphp
                                        <li>
                                            <small class="fw-semibold">{{ $status['name'] }}</small>
                                            <div class="stat-percent fw-normal text-{{ $status['color'] }}">{{ $count }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
