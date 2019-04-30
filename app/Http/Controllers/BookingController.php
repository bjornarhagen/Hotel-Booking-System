<?php

namespace App\Http\Controllers;

use App\User;
use App\Room;
use App\Hotel;
use App\Booking;
use App\BookingUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_session:booking-active')->except('show_step_2');

    public function index(Request $request, Hotel $hotel)
    {
        return view('booking.index', compact('hotel'));
    }

    public function edit(Request $request, Hotel $hotel, Booking $booking)
    {
        return view('booking.edit', compact('hotel', 'booking'));
    }

    protected function booking_validator_update(array $data, Hotel $hotel, Booking $booking)
    {
        $people_count = $booking->data->count();
        $user_ids = $booking->data->pluck('user_id')->toArray();
        
        $email_rules = [];
        foreach ($user_ids as $key => $user_id) {
            $rule_key = 'emails.' . $key;
            $rule_string = ['required', 'email', 'max:255'];
            array_push($rule_string, Rule::unique('users', 'email')->ignore($user_id));

            array_push($email_rules, [
                $rule_key,
                $rule_string
            ]);
        }

        return Validator::make($data, [
            'firstnames' => ['required', 'array', 'min:' . $people_count, 'max:' . $people_count],
            'firstnames.*' => ['required', 'string', 'max:255'],
            'lastnames' => ['required', 'array', 'min:' . $people_count, 'max:' . $people_count],
            'lastnames.*' => ['required', 'string', 'max:255'],
            'emails' => ['required', 'array', 'min:' . $people_count, 'max:' . $people_count],
            $email_rules,
            // 'emails.*' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user_ids)],
            'check_in_date' => ['required', 'date', 'before:check_out_date', 'after:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'special_wishes' => ['required', 'array', 'min:' . $people_count, 'max:' . $people_count],
            'special_wishes.*' => ['nullable', 'string', 'max:3000'],
            'rooms' => ['required', 'array', 'min:' . $people_count, 'max:' . $people_count],
            'rooms.*' => ['required', 'integer', Rule::in($booking->rooms->pluck('id')->toArray())],
            'parking' => ['required', 'array', 'min:' . $people_count, 'max:' . $people_count],
            'parking.*' => ['required', 'string', 'in:yes,no'],
            'meals' => ['nullable', 'array'],
            'meals.*' => ['nullable', 'array'],
            'meals.*.*' => ['required_with:meals.*', 'string', Rule::in($hotel->meal_names)]
        ]);
    }

    public function update(Request $request, Hotel $hotel, Booking $booking)
    {
        $user = $request->user();
        $roles = Role::whereIn('slug', ['hotel_manager', 'hotel_employee'])->get();
        $user_is_guest = true;

        foreach ($roles as $role) {
            if ($user->hasRoleAtHotel($hotel, $role)) {
                $user_is_guest = false;
                continue;
            }
        }

        if ($user_is_guest) {
            dump('user is guest');
        } else {
            dump('user is admin');
        }

        $validator = $this->booking_validator_update($request->all(), $hotel, $booking);
        $validator->validate();

        foreach ($booking->data as $booking_data) {
            $booking_user = $booking_data->user;
            $i = $booking_user->id;

            // Update user
            $booking_user->name_first = $request->firstnames[$i];
            $booking_user->name_last = $request->lastnames[$i];
            $booking_user->email = $request->emails[$i];
            $booking_user->save();

            // Update dates and special wishes
            $booking_data->special_wishes = $request->special_wishes[$i];
            $booking_data->date_check_in = $request->check_in_date;
            $booking_data->date_check_out = $request->check_out_date;

            // Update room
            $booking_data->room_id = $request->rooms[$i];
            $booking_data->price_room = ($booking_data->room->price * $booking_data->days);
            
            // Update parking
            $booking_data->parking = ($request->parking[$i] === 'yes');
            if ($booking_data->parking) {
                $booking_data->price_parking = ($hotel->price_parking_spot * $booking_data->days);
            }

            // Update meals
            if (isset($request->meals[$i])) {
                $meals = $request->meals[$i];
                $booking_data->meal_breakfast = in_array('breakfast', $meals);
                $booking_data->meal_lunch = in_array('lunch', $meals);
                $booking_data->meal_dinner = in_array('dinner', $meals);
                $booking_data->price_meals = 0;

                // Update meal prices
                if ($booking_data->meal_breakfast) {
                    $booking_data->price_meals += ($hotel->price_meal_breakfast * $booking_data->days);
                }
                
                if ($booking_data->meal_lunch) {
                    $booking_data->price_meals += ($hotel->price_meal_lunch * $booking_data->days);
                }

                if ($booking_data->meal_dinner) {
                    $booking_data->price_meals += ($hotel->price_meal_dinner * $booking_data->days);
                }
            } else {
                $booking_data->meal_breakfast = false;
                $booking_data->meal_lunch = false;
                $booking_data->meal_dinner = false;
                $booking_data->price_meals = 0;
            }

            // Update discount and balance
            $booking_data->discount = 0;
            $booking_data->balance = 0;
            $booking_data->balance += $booking_data->price_room;
            $booking_data->balance += $booking_data->price_parking;
            $booking_data->balance += $booking_data->price_meals;

            $booking_data->save();
        }

        $request->session()->flash('success', __('Your changes were saved.'));
        return redirect()->route('admin.hotel.booking.edit', [$hotel, $booking]);
    }

    public function delete(Request $request, Hotel $hotel, Booking $booking)
    {
        return view('booking.delete', compact('hotel', 'booking'));
    }

    public function destroy(Request $request, Hotel $hotel, Booking $booking)
    {
    }

    public function show_step_1(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();

        $check_in_date = $request->session()->get('booking-check_in_date');
        $check_in_day = $check_in_date->format('d');
        $check_in_month = $check_in_date->format('m');
        $check_in_year = $check_in_date->format('Y');

        $check_out_date = $request->session()->get('booking-check_out_date');
        $check_out_day = $check_out_date->format('d');
        $check_out_month = $check_out_date->format('m');
        $check_out_year = $check_out_date->format('Y');

        $people = $request->session()->get('booking-people_count');

        return view('booking.show-step-1', compact(
            'hotel',
            'check_in_day',
            'check_in_month',
            'check_in_year',
            'check_out_day',
            'check_out_month',
            'check_out_year',
            'people'
        ));
    }

    // Validator to run before manipulating data
    protected function booking_validator_step_1_pre(array $data)
    {
        return Validator::make($data, [
            'check_in_day' => ['required', 'numeric', 'min:1', 'max:31'],
            'check_in_month' => ['required', 'numeric', 'min:1', 'max:12'],
            'check_in_year' => ['required', 'integer', 'min:' . date('Y'), 'max:' . (date('Y') + 1)],
            'check_out_day' => ['required', 'numeric', 'min:1', 'max:31'],
            'check_out_month' => ['required', 'numeric', 'min:1', 'max:12'],
            'check_out_year' => ['required', 'integer', 'min:' . date('Y'), 'max:' . (date('Y') + 1)],
            'people' => ['required', 'integer', 'min:1', 'max:15']
        ]);
    }

    // Validator to run after manipulating data
    protected function booking_validator_step_1_post(array $data)
    {
        return Validator::make($data, [
            'check_in_date' => ['required', 'date', 'before:check_out_date', 'after:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'people' => ['required', 'integer', 'min:1', 'max:15']
        ]);
    }

    public function show_step_2(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();

        // If the request has no parameters and the booking session is active, the user just went
        // back to look at step 2, which means we already have data from the session, no need to validate
        if ($request->all() === [] && $request->session()->has('booking-active')) {
            $check_in_date = $request->session()->get('booking-check_in_date');
            $check_out_date = $request->session()->get('booking-check_out_date');
            $people = $request->session()->get('booking-people_count');
        } else {
            // Validate initial data
            $pre_validator = $this->booking_validator_step_1_pre($request->all());
            if ($pre_validator->fails()) {
                return redirect()->route('hotel.show', $hotel->slug)->withErrors($pre_validator)->withInput();
            }

            // Convert day, month and year fields into a date
            $check_in_date = $request->check_in_year . '-' . $request->check_in_month . '-' . $request->check_in_day;
            $check_in_date = new Carbon($check_in_date);
            $request->merge(['check_in_date' => $check_in_date]);

            $check_out_date = $request->check_out_year . '-' . $request->check_out_month . '-' . $request->check_out_day;
            $check_out_date = new Carbon($check_out_date);
            $request->merge(['check_out_date' => $check_out_date]);

            // Validate the new date fields
            $post_validator = $this->booking_validator_step_1_post($request->all());
            if ($post_validator->fails()) {
                return redirect()->route('hotel.show', $hotel->slug)->withErrors($post_validator)->withInput();
            }

            // Save data to session
            $request->session()->put('booking-active', true);
            $request->session()->put('booking-check_in_date', $check_in_date);
            $request->session()->put('booking-check_out_date', $check_out_date);
            $request->session()->put('booking-people_count', $request->people);

            $people = $request->people;
        }

        $room_types = $hotel->room_types;

        return view('booking.show-step-2', compact('hotel', 'room_types', 'check_in_date', 'check_out_date', 'people'));
    }

    protected function booking_validator_step_2(Request $request, Hotel $hotel)
    {
        $people_count = $request->session()->get('booking-people_count');
        $check_in_date = $request->session()->get('booking-check_in_date');
        $check_out_date = $request->session()->get('booking-check_out_date');
        $available_room_ids = $hotel->available_rooms($check_in_date, $check_out_date);
        $available_room_ids = $available_room_ids->pluck('id')->toArray();

        return Validator::make($request->all(), [
            'rooms' => ['required', 'array', 'min:1', 'max:' . $people_count, Rule::in($available_room_ids)],
        ]);
    }

    public function store_step_2(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();
        $this->booking_validator_step_2($request, $hotel)->validate();

        // Save rooms in session
        $request->session()->put('booking-rooms', $request->rooms);

        return redirect()->route('hotel.booking.step-3', $hotel->slug);
    }

    public function show_step_3(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();
        $people_count = $request->session()->get('booking-people_count');
        $check_in_date = $request->session()->get('booking-check_in_date');
        $check_out_date = $request->session()->get('booking-check_out_date');

        if ($request->session()->has('booking-rooms')) {
            $rooms = $request->session()->get('booking-rooms');
            $rooms = Room::whereIn('id', $rooms)->get();
        } else {
            $request->session()->flash('error', __('You need to select a room first.'));
            return redirect()->route('hotel.booking.step-2', $hotel->slug);
        }

        $room_names = [];
        foreach ($rooms as $room) {
            array_push($room_names, $room->name);
        }
        $room_names = implode(', ', $room_names);

        $meals = $hotel->meals;
        $parking_spots = $hotel->parking_spots;
        $parking_spots_available = $hotel->available_parking_spots($check_in_date, $check_out_date);
        $parking_spot_price = $hotel->price_parking_spot;

        return view('booking.show-step-3', compact(
            'hotel',
            'check_in_date',
            'check_out_date',
            'people_count',
            'room_names',
            'rooms',
            'meals',
            'parking_spots',
            'parking_spot_price',
            'parking_spots_available'
        ));
    }

    protected function booking_validator_step_3_firstnames(array $data)
    {
        return Validator::make($data, [
            'firstnames' => ['required', 'array'],
            'firstnames.*' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function booking_validator_step_3_lastnames(array $data)
    {
        return Validator::make($data, [
            'lastnames' => ['required', 'array'],
            'lastnames.*' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function booking_validator_step_3_emails(array $data)
    {
        return Validator::make($data, [
            'emails' => ['required', 'array'],
            'emails.*' => ['required', 'email', 'max:255'],
        ]);
    }

    protected function booking_validator_step_3_wishes(array $data)
    {
        return Validator::make($data, [

            'special_wishes' => ['required', 'array'],
            'special_wishes.*' => ['nullable', 'string', 'max:3000'],
        ]);
    }

    protected function booking_validator_step_3_meals(array $data)
    {
        return Validator::make($data, [
            'meals' => ['required', 'array'],
            'meals.*' => ['nullable', 'array'],
            'meals.*.*' => ['required_with:meals.*', 'in:breakfast,lunch,dinner'],
        ]);
    }

    protected function booking_validator_step_3_rooms(array $data)
    {
        $people = session()->get('booking-people_count');
        $check_in_date = session()->get('booking-check_in_date');
        $check_out_date = session()->get('booking-check_out_date');
        $rooms = session()->get('booking-rooms');

        return Validator::make($data, [
            'room_people' => ['required', 'array', 'min:' . $people, 'max:' . $people],
            'room_people.*' => ['required', 'integer', Rule::in($rooms)],
        ]);
    }

    protected function booking_validator_step_3_parking(array $data)
    {
        return Validator::make($data, [
            'parking' => ['required', 'in:yes,no'],
        ]);
    }

    protected function booking_validator_step_3_parking_people(array $data)
    {
        $people = session('booking-people_count');

        return Validator::make($data, [
            'parking_people' => ['required', 'array', 'min:1', 'max:' . $people],
            'parking_people.*' => ['required', 'integer', 'min:0', 'max:' . $people],
        ]);
    }

    public function store_step_3(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();
        $failed_validators = [];

        // Go through and validate all submitted values.
        // We do this one and one, so that if some of fields pass it's validator, we can save it
        // to session in order to improve the user experience.

        $firstnames_validator = $this->booking_validator_step_3_firstnames($request->all());
        if ($firstnames_validator->passes()) {
            $request->session()->put('booking-firstnames', $request->firstnames);
        } else {
            array_push($failed_validators, $firstnames_validator);
        }

        $lastnames_validator = $this->booking_validator_step_3_lastnames($request->all());
        if ($lastnames_validator->passes()) {
            $request->session()->put('booking-lastnames', $request->lastnames);
        } else {
            array_push($failed_validators, $lastnames_validator);
        }

        $emails_validator = $this->booking_validator_step_3_emails($request->all());
        if ($emails_validator->passes()) {
            $request->session()->put('booking-emails', $request->emails);
        } else {
            array_push($failed_validators, $emails_validator);
        }

        $wishes_validator = $this->booking_validator_step_3_wishes($request->all());
        if ($wishes_validator->passes()) {
            $request->session()->put('booking-special_wishes', $request->special_wishes);
        } else {
            array_push($failed_validators, $wishes_validator);
        }

        $meals_validator = $this->booking_validator_step_3_meals($request->all());
        if ($meals_validator->passes()) {
            $request->session()->put('booking-meals', $request->meals);
        } else {
            array_push($failed_validators, $meals_validator);
        }

        $rooms_validator = $this->booking_validator_step_3_rooms($request->all());
        if ($rooms_validator->passes()) {
            $request->session()->put('booking-room_people', $request->room_people);
        } else {
            array_push($failed_validators, $rooms_validator);
        }

        $parking_validator = $this->booking_validator_step_3_parking($request->all());
        if ($parking_validator->passes()) {
            $request->session()->put('booking-parking', $request->parking);
        } else {
            array_push($failed_validators, $parking_validator);
        }
        
        // Loop through the failed validators and get the error messages
        $error_messages = [];
        foreach ($failed_validators as $validator) {
            $validator_messages = $validator->messages()->getMessages();

            foreach ($validator_messages as $key => $value) {
                $error_messages[$key] = $value[0];
            }
        }

        // If we have any errors, send the user back to the view and display the errors
        if (!empty($error_messages)) {
            return redirect()->back()->withErrors($error_messages)->withInput();
        }

        // Validate booking per person
        $this->booking_validator_step_3_parking_people($request->all())->validate();
        $request->session()->put('booking-parking_people', $request->parking_people);

        // A last little check to make sure we don't get any offset errors
        $people_count = $request->session()->get('booking-people_count');
        $error = false;
        if (
            $people_count != count($request->firstnames)
            || $people_count != count($request->lastnames)
            || $people_count != count($request->emails)
            || $people_count != count($request->special_wishes)
            || $people_count != count($request->meals)
        ) {
            $error = true;
        }

        if ($error) {
            $request->session()->flash('error', __('Something went wrong. We couldn\'t process your users data'));
            return redirect()->back()->withInput();
        }

        $check_in_date = $request->session()->get('booking-check_in_date');
        $check_out_date = $request->session()->get('booking-check_out_date');
        $booking_days = $check_in_date->diffInDays($check_out_date);
        $rooms = $request->session()->get('booking-rooms');
        $rooms = Room::whereIn('id', $rooms)->get();

        $booking = new Booking;
        $booking->hotel_id = $hotel->id;
        $booking->save();

        for ($i=0; $i < $people_count; $i++) { 
            $input_user = [
                'firstname' => $request->firstnames[$i],
                'lastname' => $request->lastnames[$i],
                'email' => $request->emails[$i],
                'special_wishes' => $request->special_wishes[$i],
                'meals' => $request->meals[$i],
                'room' => $request->room_people[$i],
                'parking' => in_array($i, $request->parking_people)
            ];

            // Check if this person already has a user
            $user = User::where('email', $input_user['email'])->first();

            if ($user === null) {
                // No user found, let's make one
                $user = new User;
                $user->name_first = $input_user['firstname'];
                $user->name_last = $input_user['lastname'];
                $user->email = $input_user['email'];
                $user->password = Hash::make($user->firstname . $booking->id);
                $user->save();
            }

            // Create booking user
            $booking_user = new BookingUser;
            $booking_user->booking_id = $booking->id;
            $booking_user->room_id = $input_user['room'];
            $booking_user->user_id = $user->id;
            $booking_user->date_check_in = $check_in_date;
            $booking_user->date_check_out = $check_out_date;
            $booking_user->is_main_booker = 0;
            $booking_user->meal_breakfast = 0;
            $booking_user->meal_lunch = 0;
            $booking_user->meal_dinner = 0;
            $booking_user->parking = 0;
            $booking_user->special_wishes = 0;
            $booking_user->price_room = 0;
            $booking_user->price_meals = 0;
            $booking_user->price_parking = 0;
            $booking_user->price_wishes = 0;
            $booking_user->discount = 0;
            $booking_user->balance = 0;

            // % discount
            // $discount_to_apply = 0;

            // Calculate the price of the meals
            if (in_array('breakfast', $input_user['meals'])) {
                $booking_user->meal_breakfast = 1;
                $booking_user->price_meals += ($hotel->price_meal_breakfast * $booking_days);
            }

            if (in_array('lunch', $input_user['meals'])) {
                $booking_user->meal_lunch = 1;
                $booking_user->price_meals += ($hotel->price_meal_lunch * $booking_days);
            }

            if (in_array('dinner', $input_user['meals'])) {
                $booking_user->meal_dinner = 1;
                $booking_user->price_meals += ($hotel->price_meal_dinner * $booking_days);
            }

            // Calculate price of parking
            if ($input_user['parking']) {
                $booking_user->parking = true;
                $booking_user->price_parking = $hotel->price_parking_spot;
            }

            // Calculate price of room
            $room = Room::find($booking_user->room_id);
            $booking_user->price_room = ($room->price * $booking_days);

            // Apply discount
            // $discount = $booking_user->price_meals * $discount_to_apply/100;
            // $booking_user->price_meals -= $discount;
            
            // $discount = $booking_user->price_parking * $discount_to_apply/100;
            // $booking_user->price_parking -= $discount;

            $booking_user->balance += $booking_user->price_meals;
            $booking_user->balance += $booking_user->price_parking;
            $booking_user->balance += $booking_user->price_room;

            $booking_user->save();
        }

        // Clear booking data from session
        $request->session()->forget([
            'booking-active',
            'booking-rooms',
            'booking-people_count',
            'booking-check_in_date',
            'booking-check_out_date',
            'booking-firstnames',
            'booking-lastnames',
            'booking-emails',
            'booking-special_wishes',
            'booking-meals',
            'booking-room_people',
            'booking-parking',
            'booking-parking_people'
        ]);

        // TODO: SEND TO SUMMARY PAGE
        $request->session()->flash('success', __('Booking complete.'));
        return redirect()->route('hotel.show', $hotel->slug);
    }
}
