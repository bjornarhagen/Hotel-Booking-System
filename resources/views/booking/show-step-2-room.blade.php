<article class="{{ $room_classes }}">
    <div class="image" style="background-image: url('{{ asset('images/' . $hotel->slug . '/' . $room->room_type->slug . '.jpg') }}')"></div>
    @if ($checked === 'disabled')
        <h3 class="name">{{ $room->name }} - {{ __('Busy') }}</h3>
    @else
        <h3 class="name">{{ $room->name }}</h3>
    @endif
    <p class="description">{{ $room->room_type->description }}</p>
    <input id="room-checkbox-{{ $room->id }}"
        name="rooms[]"
        type="checkbox"
        value="{{ $room->id }}"
        {{ $checked }}
    >
    <label class="select" for="room-checkbox-{{ $room->id }}">
        <p class="price">{{ __('Price') }}: {{ $room->price . ',-' }}</p>
        @if ($nights > 1)
            <p class="price-nights">{{ __('Price for :nights nights', ['nights' => $nights]) }}: {{ ($room->price * $nights) . ',-' }}</p>
        @endif
        <p class="button button-primary">
            @icon('checkbox-blank', 'not-selected')
            @icon('checkbox-checked', 'selected')
            <span>{{ __('Select room') }}</span>
        </p>
    </label>
</article>