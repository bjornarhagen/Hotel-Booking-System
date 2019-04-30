<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositeKey;

class BookingUser extends Model
{
    use HasCompositeKey;

    protected $primaryKey = ['booking_id', 'user_id'];
    public $timestamps = false;
}
