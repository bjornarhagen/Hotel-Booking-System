<?php

namespace App\Http\Controllers;

use App\Room;
use App\Hotel;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function show_step_1(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();
        return redirect()->route('hotel.show', $hotel->slug)->withInput();
    }

    // Validator to run before manipulating data
    protected function booking_validator_pre(array $data)
    {
        return Validator::make($data, [
            'check_in_day' => ['required', 'numeric', 'min:1', 'max:31'],
            'check_in_month' => ['required', 'numeric', 'min:1', 'max:12'],
            'check_in_year' => ['required', 'integer', 'min:' . date('Y'), 'max:' . (date('Y') + 1)],
            'check_out_day' => ['required', 'numeric', 'min:1', 'max:31'],
            'check_out_month' => ['required', 'numeric', 'min:1', 'max:12'],
            'check_out_year' => ['required', 'integer', 'min:' . date('Y'), 'max:' . (date('Y') + 1)],
            'people' => ['required', 'integer', 'min:1', 'max:15'],
        ]);
    }

    // Validator to run after manipulating data
    protected function booking_validator_post(array $data)
    {
        return Validator::make($data, [
            'check_in_date' => ['required', 'date', 'before:check_out_date'],
            'check_out_date' => ['required', 'date', 'after:check_in_date']
        ]);
    }

    public function show_step_2(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();

        // Validate initial data
        $pre_validator = $this->booking_validator_pre($request->all());
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
        $post_validator = $this->booking_validator_post($request->all());
        if ($post_validator->fails()) {
            return redirect()->route('hotel.show', $hotel->slug)->withErrors($post_validator)->withInput();
        }

        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();
        $rooms = $hotel->rooms;

        return view('booking.show-step-2', compact('rooms', 'check_in_date', 'check_out_date'));
    }
}
