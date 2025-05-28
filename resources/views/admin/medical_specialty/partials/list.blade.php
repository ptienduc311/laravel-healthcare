@foreach ($medical_specialties as $key => $item)
    <li class="specialty-item px-2 d-flex justify-content-between align-items-center list-group-item{{$key == 0 ? " fist-item" : ""}}" data-id="{{$item->id}}">
        <div class="d-flex flex-column gap-2">
            <span>{{$item->name}}</span>
            @if ($item->pageSpecialty)
                <small class="badge bg-success">Đã có trang chuyên khoa</small>
            @else
                <small class="badge bg-danger">Chưa có trang chuyên khoa</small>
            @endif
        </div>
        <div class="pull-right">
            <button class="btn {{$item->status == 1 ? "btn-primary" : "btn-danger" }} btn-circle" type="button">
                <i class="fa {{$item->status == 1 ? "fa-check" : "fa-times" }}"></i>
            </button>
        </div>
    </li>
@endforeach
