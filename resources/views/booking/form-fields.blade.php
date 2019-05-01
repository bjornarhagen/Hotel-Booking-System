<fieldset>
    <legend>{{ __('Dates') }}</legend>

    @php
        $data = $booking->data->first();
    @endphp

    <div class="form-group">
        <label for="form-booking-check_in_date">{{ __('Check in') }}</label>
        <input id="form-booking-check_in_date"
            value="{{ old('check_in_date', $data->date_check_in->format('Y-m-d')) }}"
            type="text"
            name="check_in_date"
            required>
    </div>
    <div class="form-group">
        <label for="form-booking-check_out_date">{{ __('Check out') }}</label>
        <input id="form-booking-check_out_date"
            value="{{ old('check_out_date', $data->date_check_out->format('Y-m-d')) }}"
            type="text"
            name="check_out_date"
            required>
    </div>
</fieldset>

@foreach ($booking->data as $booking_data)
    @php
        $user = $booking_data->user;
        $firstname = isset(old('firstnames')[$user->id]) ? old('firstnames')[$user->id] : $user->name_first;
        $lastname = isset(old('lastnames')[$user->id]) ? old('lastnames')[$user->id] : $user->name_last;
        $email = isset(old('emails')[$user->id]) ? old('emails')[$user->id] : $user->email;
        $special_wishes = isset(old('special_wishes')[$user->id]) ? old('special_wishes')[$user->id] : $booking_data->special_wishes;
        $parking = isset(old('parking')[$user->id]) ? old('parking')[$user->id] : $booking_data->parking;
        $room_old = isset(old('rooms')[$user->id]) ? old('rooms')[$user->id] : $booking_data->room_id;
        $room_old = (int) $room_old;

        $original_meals = [];
        $booking_data->meal_breakfast ? array_push($original_meals, 'breakfast') : null;
        $booking_data->meal_lunch ? array_push($original_meals, 'lunch') : null;
        $booking_data->meal_dinner ? array_push($original_meals, 'dinner') : null;

        if (old('meals') !== null) {
            if (isset(old('meals')[$user->id])) {
                $meals = old('meals')[$user->id];
            } else {
                $meals = [];
            }
        } else {
            $meals = $original_meals;
        }

        $meal_breakfast = in_array('breakfast', $meals) ? true : false;
        $meal_lunch = in_array('lunch', $meals) ? true : false;
        $meal_dinner = in_array('dinner', $meals) ? true : false;
    @endphp
    <fieldset>
        <legend>{{ $user->name }}</legend>
        <div class="form-group">
            <label for="form-booking-person-firstname-{{ $user->id }}">{{ __('First name') }}</label>
            <input id="form-booking-person-firstname-{{ $user->id }}"
                value="{{ $firstname }}"
                type="text"
                name="firstnames[{{ $user->id }}]">
        </div>
        <div class="form-group">
            <label for="form-booking-person-lastname-{{ $user->id }}">{{ __('Last name') }}</label>
            <input id="form-booking-person-lastname-{{ $user->id }}"
                value="{{ $lastname }}"
                type="text"
                name="lastnames[{{ $user->id }}]">
        </div>
        <div class="form-group">
            <label for="form-booking-person-email-{{ $user->id }}">{{ __('Email') }}</label>
            <input id="form-booking-person-email-{{ $user->id }}"
                value="{{ $email }}"
                type="email"
                name="emails[{{ $user->id }}]">
        </div>
        <div class="form-group">
            <label for="form-booking-person-wishes-{{ $user->id }}">{{ __('Wishes') }}</label>
            <textarea id="form-booking-person-wishes-{{ $user->id }}"
                name="special_wishes[{{ $user->id }}]"
                >{{ $special_wishes }}</textarea>
        </div>

        <fieldset>
            <legend>{{ __('Meals') }}</legend>
            <div class="form-group">
                <input id="form-booking-person-meal-breakfast-{{ $user->id }}"
                    value="breakfast"
                    type="checkbox"
                    name="meals[{{ $user->id }}][]"
                    {{ $meal_breakfast ? 'checked' : null }}>
                <label for="form-booking-person-meal-breakfast-{{ $user->id }}">{{ __('Breakfast') }}</label>
            </div>
            <div class="form-group">
                <input id="form-booking-person-meal-lunch-{{ $user->id }}"
                    value="lunch"
                    type="checkbox"
                    name="meals[{{ $user->id }}][]"
                    {{ $meal_lunch ? 'checked' : null }}>
                <label for="form-booking-person-meal-lunch-{{ $user->id }}">{{ __('Lunch') }}</label>
            </div>
            <div class="form-group">
                <input id="form-booking-person-meal-dinner-{{ $user->id }}"
                    value="dinner"
                    type="checkbox"
                    name="meals[{{ $user->id }}][]"
                    {{ $meal_dinner ? 'checked' : null }}>
                <label for="form-booking-person-meal-dinner-{{ $user->id }}">{{ __('Dinner') }}</label>
            </div>
        </fieldset>
        <fieldset>
            <legend>{{ __('Parking') }}</legend>
            <div class="form-group">
                <input id="form-booking-person-parking-yes-{{ $user->id }}"
                    value="yes"
                    type="radio"
                    name="parking[{{ $user->id }}]"
                    {{ ($parking === 1 || $parking === 'yes') ? 'checked' : null }}>
                <label for="form-booking-person-parking-yes-{{ $user->id }}">{{ __('Yes') }}</label>
            </div>
            <div class="form-group">
                <input id="form-booking-person-parking-no-{{ $user->id }}"
                    value="no"
                    type="radio"
                    name="parking[{{ $user->id }}]"
                    {{ ($parking === 0 || $parking === 'no') ? 'checked' : null }}>
                <label for="form-booking-person-parking-no-{{ $user->id }}">{{ __('No') }}</label>
            </div>
        </fieldset>
        <fieldset>
            <legend>{{ __('Room') }}</legend>
            @foreach ($booking->rooms as $room)
                <div class="form-group">
                    <input id="form-booking-person-room-{{ $room->id }}-{{ $user->id }}"
                        value="{{ $room->id }}"
                        type="radio"
                        name="rooms[{{ $user->id }}]"
                        {{ $room_old === $room->id ? 'checked' : null }}>
                    <label for="form-booking-person-room-{{ $room->id }}-{{ $user->id }}">{{ $room->name }} ({{ $room->room_type->name }})</label>
                </div>
            @endforeach
        </fieldset>
    </fieldset>
@endforeach

{{-- 
    <div class="form-group">
        <label for="form-hotel-description">{{ __('Description') }}</label>
        <textarea id="form-hotel-description"
            value="{{ old('description', isset($hotel->description) ? $hotel->description : null) }}"
            name="description"></textarea>
    </div> --}}