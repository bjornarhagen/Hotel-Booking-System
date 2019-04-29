<?php

namespace App;

use Carbon\Carbon;
use App\BookingUser;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $appends = [
        'name',
        'price',
    ];

    public function getNameAttribute()
    {
        return $this->group . $this->number;
    }

    public function room_type()
    {
        return $this->belongsTo('App\RoomType');
    }

    // Default price is the room type price, but it can be overwritten on a per room basis
    public function getPriceAttribute($value)
    {
        if ($value === null) {
            $value = $this->room_type->price;
        }

        return $value;
    }

    public function isAvailable(Carbon $date_check_in, Carbon $date_check_out)
    {
        // Try to find bookings which are active during the desired check in and out time.
        // If we find any, that means the room is busy
        $bookings = BookingUser::where('room_id', $this->id)
        ->where('date_check_in', '<', $date_check_out)
        ->where('date_check_out', '>', $date_check_in)
        ->get();

        return $bookings->count() === 0;
    }
}
