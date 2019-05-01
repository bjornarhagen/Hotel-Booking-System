<span class="item">{{ $booking_data->user->name }}</span>
<span class="item">{{ $booking_data->room->name }}</span>
@php
    $title = $booking_data->date_check_in->format('Y-m-d');
    $title .= ' (' . $booking_data->date_check_in->diffForHumans() . ')';
    $value = $booking_data->date_check_in->format('l d.m');
@endphp
<span class="item" title="{{ $title }}">{{ $value }}</span>
@php
    $title = $booking_data->date_check_out->format('Y-m-d');
    $title .= ' (' . $booking_data->date_check_out->diffForHumans() . ')';
    $value = $booking_data->date_check_out->format('l d.m');
@endphp
<span class="item" title="{{ $title }}">{{ $value }}</span>
<span class="item">{{ $booking_data->days }}</span>
<span class="item">{{ $booking_data->is_main_booker ? __('Yes')[0] : __('No')[0] }}</span>
<span class="item">{{ $booking_data->meal_breakfast ? __('Yes')[0] : __('No')[0] }}</span>
<span class="item">{{ $booking_data->meal_lunch ? __('Yes')[0] : __('No')[0] }}</span>
<span class="item">{{ $booking_data->meal_dinner ? __('Yes')[0] : __('No')[0] }}</span>
<span class="item">{{ $booking_data->parking ? __('Yes')[0] : __('No')[0] }}</span>
{{-- <span class="item">{{ $booking_data->special_wishes }}</span> --}}
{{-- <span class="item">{{ $booking_data->price_wishes }}</span> --}}
<span class="item">{{ $booking_data->price_parking }}</span>
<span class="item">{{ $booking_data->price_meals }}</span>
<span class="item">{{ $booking_data->price_room }}</span>
{{-- <span class="item">{{ $booking_data->discount }}</span> --}}
{{-- <span class="item">{{ $booking_data->balance }}</span> --}}