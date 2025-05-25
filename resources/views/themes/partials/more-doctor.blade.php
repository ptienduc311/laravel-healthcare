@foreach ($data as $item)
<div class="team-item">
    <div class="team-item-info">
        <div class="team-item-photo">
            <a href="/doi-ngu-chuyen-gia/{{$item->slug_name}}" class="avatar-doctor">
                <img src="{{ $item->avatar_url }}" alt="Ảnh {{$item->name}}">
            </a>
            <span class="circle"></span>
        </div>
        <div class="team-item-details">
            <h3 class="team-item-name">
                <a href="/doi-ngu-chuyen-gia/{{$item->slug_name}}">{{$item->name}}</a>
            </h3>
            <div class="team-item-special">
                <a href="">Chuyên khoa - {{ $item->specialty?->name }}</a>
            </div>
            <div class="team-item-review">
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
            </div>
            <div class="team-item-book">
                <a href="/doi-ngu-chuyen-gia/{{$item->slug_name}}#book-doctor">Đặt lịch khám</a>
            </div>
        </div>
    </div>
</div>
@endforeach