<?php

namespace App\Http\Controllers;

use App\Room;
use App\Hotel;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('check_session:booking-active')->except('show_step_2');
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
            'check_in_date' => ['required', 'date', 'before:check_out_date'],
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
        $check_in_date = $request->session()->get('booking-check_in_date');
        $check_out_date = $request->session()->get('booking-check_out_date');
        $available_room_ids = $hotel->available_rooms($check_in_date, $check_out_date);
        $available_room_ids = $available_room_ids->pluck('id')->toArray();

        return Validator::make($request->all(), [
            'rooms' => ['required', 'array', 'min:1', Rule::in($available_room_ids)],
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
        dump( $request->session()->get('booking-special_wishes') );

        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();
        $people_count = $request->session()->get('booking-people_count');
        $check_in_date = $request->session()->get('booking-check_in_date');
        $check_out_date = $request->session()->get('booking-check_out_date');

        $rooms = $request->session()->get('booking-rooms');
        $rooms = Room::whereIn('id', $rooms)->get();

        $room_names = [];
        foreach ($rooms as $room) {
            array_push($room_names, $room->name);
        }
        $room_names = implode(', ', $room_names);

        $meals = ['breakfast', 'lunch', 'dinner'];

        return view('booking.show-step-3', compact(
            'hotel',
            'check_in_date',
            'check_out_date',
            'people_count',
            'room_names',
            'rooms',
            'meals'
        ));
    }

    protected function booking_validator_step_3(array $data)
    {
        return Validator::make($data, [
            'firstnames' => ['required', 'array'],
            'firstnames.*' => ['required', 'string', 'max:255'],
            'lastnames' => ['required', 'array'],
            'lastnames.*' => ['required', 'string', 'max:255'],
            'emails' => ['required', 'array'],
            'emails.*' => ['required', 'email', 'max:255'],
            'special_wishes' => ['required', 'array'],
            'special_wishes.*' => ['nullable', 'string', 'max:3000'],
            'meals' => ['required', 'array'],
            'meals.*' => ['nullable', 'array'],
            'meals.*.*' => ['required_with:meals.*', 'in:breakfast,lunch,dinner'],
        ]);
    }

    public function store_step_3(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();
        $this->booking_validator_step_3($request->all())->validate();

        $request->session()->put('booking-firstnames', $request->firstnames);
        $request->session()->put('booking-lastnames', $request->lastnames);
        $request->session()->put('booking-emails', $request->emails);
        $request->session()->put('booking-special_wishes', $request->special_wishes);
        $request->session()->put('booking-meals', $request->meals);

        return redirect()->route('hotel.booking.step-3', $hotel->slug);
    }
}
