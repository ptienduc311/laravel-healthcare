@foreach ($medical_specialties as $key => $item)
    <li class="speacialty-item d-flex justify-content-between align-items-center list-group-item{{$key == 0 ? " fist-item" : ""}}" data-id="{{$item->id}}">
        <span>{{$item->name}}</span>
        <div class="pull-right">
            <button class="btn {{$item->status == 1 ? "btn-primary" : "btn-danger" }} btn-circle" type="button">
                <i class="fa {{$item->status == 1 ? "fa-check" : "fa-times" }}"></i>
            </button>
        </div>
    </li>
@endforeach
