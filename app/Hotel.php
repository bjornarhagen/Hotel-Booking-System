<?php

namespace App;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public $appends = [
        'address',
        'address_lat_lon'
    ];

    public function brand_logo()
    {
        return $this->hasOne('App\Image', 'id', 'brand_logo_id')->withDefault(function ($image) {
            $image->url = asset('/images/default-hotel.svg');
            $image->is_default = true;
        });
    }

    public function brand_icon()
    {
        return $this->hasOne('App\Image', 'id', 'brand_icon_id')->withDefault(function ($image) {
            $image->url = asset('/images/default-hotel.svg');
            $image->is_default = true;
        });
    }

    public function room_types()
    {
        return $this->hasMany('App\RoomType');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function getRoomsAttribute()
    {
        $room_types = RoomType::where('hotel_id', $this->id)->pluck('id')->toArray();
        return Room::whereIn('room_type_id', $room_types)->get();
    }

    public function getAddressAttribute()
    {
        $address = '';

        if ($this->address_street !== null) {
            $address .= $this->address_street;
        }

        if ($this->address_zip !== null) {
            $seperator = '';

            if ($address !== null) {
                $seperator = ', ';
            }

            $address .= $seperator . $this->address_zip;
        }

        if ($this->address_city !== null) {
            $seperator = '';

            if ($address !== null) {
                $seperator = ' ';
            }

            $address .= $seperator . $this->address_city;
        }

        if ($address === '') {
            $address = null;
        }

        return $address;
    }

    public function getAddressLatLonAttribute()
    {
        $lat_lon = null;

        if ($this->address_lat !== null) {
            $lat_lon = number_format((float)$this->address_lat, 2, '.', '');
        }

        if ($this->address_lon !== null && $lat_lon !== null) {
            $lat_lon .= ', ' . number_format((float)$this->address_lon, 2, '.', '');
        }

        return $lat_lon;
    }

    public function available_rooms(Carbon $date_check_in, Carbon $date_check_out)
    {
        $rooms = new Collection();

        foreach($this->room_types as $room_type) {
            $room_type_rooms = $room_type->availableRooms($date_check_in, $date_check_out);

            foreach($room_type_rooms as $room) {
                $rooms->add($room);
            }
        }

        return $rooms;
    }

    public function available_parking_spots(Carbon $date_check_in, Carbon $date_check_out)
    {
        $parking_spots = $this->parking_spots;

        if ($parking_spots !== 0) {
            // Find amount of parking spots which are taken during the desired check in and out time
            $unavailable_parking_spots = BookingUser::select(
                'booking_id',
                'date_check_in',
                'date_check_out',
                'parking',
                'hotel_id'
            )->join('bookings', 'booking_users.booking_id', '=', 'bookings.id')
            ->where('date_check_in', '<', $date_check_out)
            ->where('date_check_out', '>', $date_check_in)
            ->where('hotel_id', $this->id)
            ->where('parking', 1)
            ->count();

            $parking_spots -= $unavailable_parking_spots;
        }

        return $parking_spots;
    }

    public function getMealNamesAttribute()
    {
        return ['breakfast', 'lunch', 'dinner'];
    }

    public function getMealsAttribute()
    {
        $meal_names = $this->meal_names;
        $meals = [];

        for ($i=0; $i < count($meal_names); $i++) { 
            $meals[$i] = [
                'name' => $meal_names[$i],
                'price' => $this->{'price_meal_' . $meal_names[$i]}
            ];
        }

        return $meals;
    }
}
