@foreach ($data as $item)
    <div class="post-item post-item-list">
        <div class="post-item-info">
            <div class="post-item-photo">
                <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}" class="post-image-container">
                    <img src="{{ Storage::url($item->image?->src) }}" alt="Ảnh {{$item->title}}">
                </a>
            </div>
            <div class="post-item-details">
                <div class="post-item-date">
                    <i class="fa-regular fa-clock"></i>
                    {{ date('d/m/Y', $item->created_date_int) }}
                </div>
                <h3 class="post-item-title">
                    <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}">
                        {{ $item->title }}
                    </a>
                </h3>
                <div class="post-item-excerpt">
                    {{ $item->description }}
                </div>
            </div>
        </div>
    </div>
@endforeach