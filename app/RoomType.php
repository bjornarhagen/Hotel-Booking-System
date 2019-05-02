<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    public $timestamps = false;

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }

    public function availableRooms(Carbon $date_check_in, Carbon $date_check_out)
    {
        $rooms = new Collection();

        foreach ($this->rooms as $room) {
            if ($room->isAvailable($date_check_in, $date_check_out)) {
                $rooms->push($room); // Use add in newer Laravel version
            }
        }

        return $rooms;
    }

    public function unavailableRooms(Carbon $date_check_in, Carbon $date_check_out)
    {
        $rooms = new Collection();
        
        $available_rooms =  $this->availableRooms($date_check_in, $date_check_out);
        $available_rooms = $available_rooms->pluck('id')->toArray();
        
        $unavailable_rooms = Room::where('room_type_id', $this->id)->whereNotIn('id', $available_rooms)->get();

        return $unavailable_rooms;
    }
}
