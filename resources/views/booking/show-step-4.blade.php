@extends('partials.master')

@section('content')
    @include('booking.nav')
    <form method="post" action="{{ route('hotel.booking.step-3', $hotel->slug) }}">
        @csrf
        <header>
            <h1>{{ __('Your booking') }}</h1>
            
            <p>{{ __('Check in') }}: {{ $check_in_date->format('d. F Y') }}</p>
            <p>{{ __('Check out') }}: {{ $check_out_date->format('d. F Y') }}</p>
            <p>{{ __('Rooms') }}: {{ $room_names }}</p>

            <button type="submit">{{ __('Continue') }}</button>
        </header>
        <section class="room_types">
            @for ($i = 0; $i < $people_count; $i++)
                <article>
                    <h2>{{ __('Person') }} {{ $i + 1 }}</h2>
                    @if ($i === 0 && $people_count > 1)
                        <p>{{ __('This person is responsible for the order.') }}</p>
                    @endif

                    <div class="form-group">
                        @php
                            $current_value = old('firstnames', session('booking-firstnames'));

                            if (!empty($current_value) && isset($current_value[$i])) {
                                $current_value = $current_value[$i];
                            }
                        @endphp
                        <label for="form-booking-person-firstname-{{ $i }}">{{ __('First name') }}</label>
                        <input id="form-booking-person-firstname-{{ $i }}" type="text" name="firstnames[]" value="{{ $current_value }}" required>
                    </div>

                    <div class="form-group">
                        @php
                            $current_value = old('lastnames', session('booking-lastnames'));

                            if (!empty($current_value) && isset($current_value[$i])) {
                                $current_value = $current_value[$i];
                            }
                        @endphp
                        <label for="form-booking-person-lastname-{{ $i }}">{{ __('Last name') }}</label>
                        <input id="form-booking-person-lastname-{{ $i }}" type="text" name="lastnames[]" value="{{ $current_value }}" required>
                    </div>

                    <div class="form-group">
                        @php
                            $current_value = old('emails', session('booking-emails'));

                            if (!empty($current_value) && isset($current_value[$i])) {
                                $current_value = $current_value[$i];
                            }
                        @endphp
                        <label for="form-booking-person-email-{{ $i }}">{{ __('Email address') }}</label>
                        <input id="form-booking-person-email-{{ $i }}" type="email" name="emails[]" value="{{ $current_value }}" required>
                    </div>

                    <div class="form-group">
                            @php
                                $current_value = old('special_wishes', session('booking-special_wishes'));
    
                                if (!empty($current_value)) {
                                    $current_value = $current_value[$i];
                                }
                            @endphp
                            <label for="form-booking-person-special_wish-{{ $i }}">{{ __('Any special wishes?') }}</label>
                            <textarea id="form-booking-person-special_wish-{{ $i }}" name="special_wishes[]">{{ $current_value }}</textarea>
                        </div>

                    <p>{{ __('Meals') }}</p>
                    @foreach ($meals as $meal)
                        <div class="form-group">
                            @php
                                $checked = false;

                                // Figure out if the meal should be checked or not
                                $label_text = __(ucfirst($meal['name']));
                                
                                // Free meals are inclusive
                                if ($meal['price'] === 0) {
                                    $checked = true;
                                    $label_text .= ' (' . __('inclusive') . ')';
                                } else {
                                    $label_text .= ' (' . $meal['price'] . ',- per dag)';
                                }

                                $selected_meals = old('meals', session('booking-meals'));

                                if (!empty($selected_meals) && isset($selected_meals[$i])) {
                                    $checked = false;
                                    $selected_meals = $selected_meals[$i];
                                }
                                
                                if (is_array($selected_meals)) {
                                    foreach ($selected_meals as $selected_meal) {
                                        if ($selected_meal === $meal['name']) {
                                            $checked = true;
                                            continue;
                                        }
                                    }
                                }

                                if ($checked) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                            @endphp
                            <input id="form-booking-meal-email-{{ $i . '-' . $loop->index }}" type="checkbox" name="meals[{{ $i }}][]" value="{{ $meal['name'] }}"{{ $checked }}>
                            <label for="form-booking-meal-email-{{ $i . '-' . $loop->index }}">{{ $label_text }}</label>
                        </div>
                    @endforeach

                    <p>{{ __('Room') }}</p>
                    @php
                        $checked = '';

                        if ($rooms->count() === 1) {
                            $checked = ' checked';
                        }
                    @endphp
                    @foreach ($rooms as $room)
                        <div class="form-group">
                            <input id="form-booking-room_people-{{ $i . '-' . $room->id }}"
                                type="radio"
                                name="room_people[{{$i}}]"
                                value="{{ $room->id }}"
                                required
                                {{ $checked }}>
                            <label for="form-booking-room_people-{{ $i . '-' . $room->id }}">{{ $room->name }} ({{ $room->room_type->name }})</label>
                        </div>
                    @endforeach
                </article>
            @endfor
        </section>
        <section>
            <h2>{{ __('Du you need parking?') }}</h2>
            @php
                $parking_radio_yes_attrs = '';
                $parking_radio_no_attrs = '';

                if ($parking_spots_available === 0) {
                    $parking_radio_yes_attrs .= ' disabled';
                    $parking_radio_no_attrs .= ' disabled checked';
                } else {
                    $parking = old('parking', session('booking-parking'));

                    if ($parking === 'yes') {
                        $parking_radio_yes_attrs .= ' checked';
                    } else if ($parking === 'no') {
                        $parking_radio_no_attrs .= ' checked';
                    }
                }
            @endphp
            
            @if ($parking_spots_available === 0)
                <p>{{ __('The parking lot is full. We\'re sorry for the inconvenience.') }}</p>
            @endif
            <div class="form-group">
                <input id="form-booking-parking-yes" type="radio" name="parking" value="yes" required{{ $parking_radio_yes_attrs }}>
                <label for="form-booking-parking-yes">{{ __('Yes') }}</label>
            </div>
            <div class="form-group">
                <input id="form-booking-parking-no" type="radio" name="parking" value="no" required{{ $parking_radio_no_attrs }}>
                <label for="form-booking-parking-no">{{ __('No') }}</label>
            </div>

            <p>{{ __('Available parking spots: :count', ['count' => $parking_spots_available]) }}</p>
            <p>{{ __('Price per day per spot') }} {{ $parking_spot_price }},-</p>

            @if ($people_count > 1)
                <h3>{{ __('Who needs parking?') }}</h3>
                <p>{{ __('Select one person per parking spot. If you are multiple people in one car, only one person needs parking.') }}</p>
                @for ($i = 0; $i < $people_count; $i++)
                    <div class="form-group">
                        <input id="form-booking-parking-email-{{ $i }}" type="checkbox" name="parking_people[]" value="{{ $i }}">
                        <label for="form-booking-parking-email-{{ $i }}">{{ __('Person') }} {{ $i + 1 }}</label>
                    </div>
                @endfor
            @endif
        </section>
    </form>
@endsection