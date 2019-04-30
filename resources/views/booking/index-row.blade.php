<div class="item">
    <span class="label">{{ __('User') }}</span>
    <span class="value">{{ $booking_data->user->name }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Room') }}</span>
    <span class="value">{{ $booking_data->room->name }}</span>
</div>
<div class="item">
    @php
        $title = $booking_data->date_check_in->format('Y-m-d');
        $title .= ' (' . $booking_data->date_check_in->diffForHumans() . ')';
        $value = $booking_data->date_check_in->format('l d.m');
    @endphp
    <span class="label">{{ __('Check in') }}</span>
    <span class="value" title="{{ $title }}">{{ $value }}</span>
</div>
<div class="item">
    @php
        $title = $booking_data->date_check_out->format('Y-m-d');
        $title .= ' (' . $booking_data->date_check_out->diffForHumans() . ')';
        $value = $booking_data->date_check_out->format('l d.m');
    @endphp
    <span class="label">{{ __('Check out') }}</span>
    <span class="value" title="{{ $title }}">{{ $value }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Days') }}</span>
    <span class="value">{{ $booking_data->days }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Main') }}</span>
    <span class="value">{{ $booking_data->is_main_booker }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Breakfast') }}</span>
    <span class="value">{{ $booking_data->meal_breakfast }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Lunch') }}</span>
    <span class="value">{{ $booking_data->meal_lunch }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Dinner') }}</span>
    <span class="value">{{ $booking_data->meal_dinner }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Parking') }}</span>
    <span class="value">{{ $booking_data->parking }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Wishes') }}</span>
    <span class="value">{{ $booking_data->special_wishes }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Price: Wishes') }}</span>
    <span class="value">{{ $booking_data->price_wishes }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Price: Parking') }}</span>
    <span class="value">{{ $booking_data->price_parking }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Price: Meals') }}</span>
    <span class="value">{{ $booking_data->price_meals }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Price: Room') }}</span>
    <span class="value">{{ $booking_data->price_room }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Discount') }}</span>
    <span class="value">{{ $booking_data->discount }}</span>
</div>
<div class="item">
    <span class="label">{{ __('Balance') }}</span>
    <span class="value">{{ $booking_data->balance }}</span>
</div>