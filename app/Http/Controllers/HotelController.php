<?php

namespace App\Http\Controllers;

use App\Image;
use App\Hotel;
use App\HotelUser;
use App\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
        $this->middleware('verified')->except('show');
        $this->middleware('hotel_role:hotel_manager')->only('edit', 'update', 'delete', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $hotels = $user->hotels;

        return view('hotel.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hotel.create');
    }

    // Validator to run before manipulating data
    protected function hotel_validator_pre(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'parking_spots' => ['nullable', 'integer', 'min:0', 'max:' . (pow(2, 32)-1)],
            'price_parking_spot' => ['nullable', 'required_with:parking_spots', 'integer', 'min:0', 'max:' . (pow(2, 32)-1)],
            'brand_color_primary' => ['nullable', 'string', 'max:10'],
            'brand_color_accent' => ['nullable', 'string', 'max:10'],
            'brand_logo' => ['nullable', 'image', 'dimensions:max_width=1024,max_height=1024', 'max:2000'],
            'brand_icon' => ['nullable', 'image', 'dimensions:max_width=1024,max_height=1024', 'max:2000'],
            'website' => ['nullable', 'URL', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'address_street' => ['nullable', 'required', 'string', 'max:255'],
            'address_city' => ['nullable', 'required', 'string', 'max:255'],
            'address_zip' => ['nullable', 'required', 'string', 'max:255'],
            'address_lat' => ['nullable', 'required_with:address_lon', 'numeric', 'min:-90', 'max:90'],
            'address_lon' => ['nullable', 'required_with:address_lat', 'numeric', 'min:-180', 'max:180'],
            'price_meal_breakfast' => ['required', 'integer', 'min:0', 'max:' . (pow(2, 32)-1)],
            'price_meal_lunch' => ['required', 'integer', 'min:0', 'max:' . (pow(2, 32)-1)],
            'price_meal_dinner' => ['required', 'integer', 'min:0', 'max:' . (pow(2, 32)-1)],
        ]);
    }

    // Validator to run after manipulating data
    protected function hotel_validator_post(array $data, $hotel_id = null)
    {
        $slug_rules = ['required', 'string', 'max:255'];

        if ($hotel_id !== null) {
            $slug_unique_rule = Rule::unique('hotels')->ignore($hotel_id);
        } else {
            $slug_unique_rule = Rule::unique('hotels');
        }

        array_push($slug_rules, $slug_unique_rule);

        return Validator::make($data, [
            'slug' => $slug_rules
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->hotel_validator_pre($request->all())->validate();
        
        if ($request->filled('slug')) {
            $request->merge(['slug' => Str::slug($request->slug)]);
        } else {
            $request->merge(['slug' => Str::slug($request->name)]);
        }

        $this->hotel_validator_post($request->all())->validate();

        $user = $request->user();
        
        $hotel = new Hotel;
        $hotel->name = $request->name;
        $hotel->slug = $request->slug;
        $hotel->description = $request->description;
        $hotel->parking_spots = $request->parking_spots;
        $hotel->price_parking_spot = $request->price_parking_spot;
        $hotel->brand_color_primary = $request->brand_color_primary;
        $hotel->brand_color_accent = $request->brand_color_accent;
        $hotel->website = $request->website;
        $hotel->contact_phone = $request->contact_phone;
        $hotel->contact_email = $request->contact_email;
        $hotel->address_street = $request->address_street;
        $hotel->address_city = $request->address_city;
        $hotel->address_zip = $request->address_zip;
        $hotel->address_lat = $request->address_lat;
        $hotel->address_lon = $request->address_lon;
        $hotel->price_meal_breakfast = $request->price_meal_breakfast;
        $hotel->price_meal_lunch = $request->price_meal_lunch;
        $hotel->price_meal_dinner = $request->price_meal_dinner;
        
        if ($hotel->save()) {
            $hotel_user = new HotelUser;
            $hotel_user->user_id = $user->id;
            $hotel_user->role_id = Role::where('slug', 'hotel_manager')->firstOrFail()->id;
            $hotel_user->hotel_id = $hotel->id;
            $hotel_user->save();
            
            $success_message = __('The :resource was created.', ['resource' => __('hotel')]);
            $request->session()->flash('success', $success_message);

            // Upload logo
            if ($request->has('brand_logo')) {
                $image = Image::upload($user, $request->file('brand_logo'), 'hotel_logos');
    
                if ($image === null) {
                    $error_message = __('Something went wrong. We couldn\'t upload the :resource.', ['resource' => __('image')]);
                    $request->session()->flash('error', $error_message);
                } else {
                    $hotel->brand_logo_id = $image->id;
                    $hotel->save();
                }
            }

            // Upload icon
            if ($request->has('brand_icon')) {
                $image = Image::upload($user, $request->file('brand_icon'), 'hotel_icons');
    
                if ($image === null) {
                    $error_message = __('Something went wrong. We couldn\'t upload the :resource.', ['resource' => __('image')]);
                    $request->session()->flash('error', $error_message);
                } else {
                    $hotel->brand_icon_id = $image->id;
                    $hotel->save();
                }
            }
        } else {
            $error_message = __('Something went wrong. We couldn\'t create the :resource.', ['resource' => __('hotel')]);
            $request->session()->flash('error', $error_message);

            $hotel->delete();
        }

        return redirect()->route('admin.hotel.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, String $hotel_slug)
    {
        $hotel = Hotel::where('slug', $hotel_slug)->firstOrFail();

        $check_in_day = null;
        $check_in_month = null;
        $check_in_year = null;
        $check_out_day = null;
        $check_out_month = null;
        $check_out_year = null;
        $people = null;

        if ($request->session()->has('booking-active')) {
            $check_in_date = $request->session()->get('booking-check_in_date');
            $check_in_day = $check_in_date->format('d');
            $check_in_month = $check_in_date->format('m');
            $check_in_year = $check_in_date->format('Y');

            $check_out_date = $request->session()->get('booking-check_out_date');
            $check_out_day = $check_out_date->format('d');
            $check_out_month = $check_out_date->format('m');
            $check_out_year = $check_out_date->format('Y');

            $people = $request->session()->get('booking-people_count');
        }

        return view('hotel.show', compact(
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        return view('hotel.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        $this->hotel_validator_pre($request->all())->validate();
        
        if ($request->filled('slug')) {
            $request->merge(['slug' => Str::slug($request->slug)]);
        } else {
            $request->merge(['slug' => Str::slug($request->name)]);
        }

        $this->hotel_validator_post($request->all(), $hotel->id)->validate();

        $user = $request->user();
        
        $hotel->name = $request->name;
        $hotel->slug = $request->slug;
        $hotel->description = $request->description;
        $hotel->parking_spots = $request->parking_spots;
        $hotel->price_parking_spot = $request->price_parking_spot;
        $hotel->brand_color_primary = $request->brand_color_primary;
        $hotel->brand_color_accent = $request->brand_color_accent;
        $hotel->website = $request->website;
        $hotel->contact_phone = $request->contact_phone;
        $hotel->contact_email = $request->contact_email;
        $hotel->address_street = $request->address_street;
        $hotel->address_city = $request->address_city;
        $hotel->address_zip = $request->address_zip;
        $hotel->address_lat = $request->address_lat;
        $hotel->address_lon = $request->address_lon;
        $hotel->price_meal_breakfast = $request->price_meal_breakfast;
        $hotel->price_meal_lunch = $request->price_meal_lunch;
        $hotel->price_meal_dinner = $request->price_meal_dinner;
        $hotel->save();

        $success_message = __('The :resource was updated.', ['resource' => __('hotel')]);
        $request->session()->flash('success', $success_message);

        // Upload logo
        if ($request->has('brand_logo')) {
            $image = Image::upload($user, $request->file('brand_logo'), 'hotel_logos');

            if ($image === null) {
                $error_message = __('Something went wrong. We couldn\'t upload the :resource.', ['resource' => __('image')]);
                $request->session()->flash('error', $error_message);
            } else {
                $hotel->brand_logo_id = $image->id;
                $hotel->save();
            }
        }

        // Upload icon
        if ($request->has('brand_icon')) {
            $image = Image::upload($user, $request->file('brand_icon'), 'hotel_icons');

            if ($image === null) {
                $error_message = __('Something went wrong. We couldn\'t upload the :resource.', ['resource' => __('image')]);
                $request->session()->flash('error', $error_message);
            } else {
                $hotel->brand_icon_id = $image->id;
                $hotel->save();
            }
        }

        return redirect()->route('admin.hotel.edit', $hotel);
    }

    /**
     * Confirm deletion of the specified resource from storage.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Hotel $hotel)
    {
        $user = $request->user();
        $manager_role = Role::where('slug', 'hotel_manager')->firstOrFail();

        return view('hotel.delete', compact('hotel'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Hotel $hotel)
    {
        $user = $request->user();
        $manager_role = Role::where('slug', 'hotel_manager')->firstOrFail();
        
        $hotel->delete();

        $success_message = __('The :resource was deleted.', ['resource' => __('hotel')]);
        $request->session()->flash('success', $success_message);

        return redirect()->route('admin.hotel.index');
    }
}
