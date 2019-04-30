<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositeKey;

class BookingUser extends Model
{
    use HasCompositeKey;

    protected $primaryKey = ['booking_id', 'user_id'];

    public $timestamps = false;

    public $dates = [
        'date_check_in',
        'date_check_out'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    public function getPriceAttribute()
    {
        $price = 0;

        $price += $this->price_wishes;
        $price += $this->price_parking;
        $price += $this->price_meals;
        $price += $this->price_room;

        return $price;
    }

    public function getDaysAttribute()
    {
        return $this->date_check_in->diffInDays($this->date_check_out);;
    }

}
