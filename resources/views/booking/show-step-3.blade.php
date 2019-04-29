@extends('partials.master')

@section('content')
    <form method="post" action="{{ route('hotel.booking.step-3', [$hotel->slug]) }}">
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

                    <div class="form-group">
                        @php
                            $current_value = old('firstnames', session('booking-firstnames'));

                            if (!empty($current_value)) {
                                $current_value = $current_value[$i];
                            }
                        @endphp
                        <label for="form-booking-person-firstname-{{ $i }}">{{ __('First name') }}</label>
                        <input id="form-booking-person-firstname-{{ $i }}" type="text" name="firstnames[]" value="{{ $current_value }}" >
                    </div>

                    <div class="form-group">
                        @php
                            $current_value = old('lastnames', session('booking-lastnames'));

                            if (!empty($current_value)) {
                                $current_value = $current_value[$i];
                            }
                        @endphp
                        <label for="form-booking-person-lastname-{{ $i }}">{{ __('Last name') }}</label>
                        <input id="form-booking-person-lastname-{{ $i }}" type="text" name="lastnames[]" value="{{ $current_value }}" >
                    </div>

                    <div class="form-group">
                        @php
                            $current_value = old('emails', session('booking-emails'));

                            if (!empty($current_value)) {
                                $current_value = $current_value[$i];
                            }
                        @endphp
                        <label for="form-booking-person-email-{{ $i }}">{{ __('Email address') }}</label>
                        <input id="form-booking-person-email-{{ $i }}" type="email" name="emails[]" value="{{ $current_value }}" >
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
                                // Figure out if the meal should be checked or not
                                $checked = ($meal === 'breakfast');
                                $label_text = __(ucfirst($meal));
                                
                                if ($meal === 'breakfast') {
                                    $label_text .= ' (' . __('inclusive') . ')';
                                }

                                $selected_meals = old('meals', session('booking-meals'));

                                if (!empty($selected_meals)) {
                                    $checked = false;
                                    $selected_meals = $selected_meals[$i];
                                }
                                
                                if (is_array($selected_meals)) {
                                    foreach ($selected_meals as $selected_meal) {
                                        if ($selected_meal === $meal) {
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
                            <input id="form-booking-meal-email-{{ $i . '-' . $loop->index }}" type="checkbox" name="meals[{{ $i }}][]" value="{{ $meal }}"{{ $checked }}>
                            <label for="form-booking-meal-email-{{ $i . '-' . $loop->index }}">{{ $label_text }}</label>
                        </div>
                    @endforeach
                </article>
            @endfor
        </section>
        <section>
            <h2>{{ __('Du you need parking?') }}</h2>
            <div class="form-group">
                <input id="form-booking-parking-yes" type="radio" name="parking" required>
                <label for="form-booking-parking-yes">{{ __('Yes') }}</label>

                <input id="form-booking-parking-no" type="radio" name="parking" required>
                <label for="form-booking-parking-no">{{ __('No') }}</label>
            </div>

            <p>{{ __('Available parking spots: :count', ['count' => mt_rand(1, 14)]) }}</p>
            <h3>{{ __('Who needs parking?') }}</h3>
            <p>{{ __('Select one person per parking spot. If you are multiple people in one car, only one person needs parking.') }}</p>
            @for ($i = 0; $i < $people_count; $i++)
                <div class="form-group">
                    <input id="form-booking-parking-email-{{ $i }}" type="checkbox" name="parkings[{{ $i }}][]">
                    <label for="form-booking-parking-email-{{ $i }}">{{ __('Person') }} {{ $i + 1 }}</label>
                <div class="form-group">
            @endfor
        </section>
    </form>
@endsection