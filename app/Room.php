<?php

namespace App;

use Carbon\Carbon;
use App\BookingUser;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $appends = [
        'name'
    ];

    public function getNameAttribute()
    {
        return $this->group . $this->number;
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
