<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function data()
    {
        return $this->hasMany('App\BookingUser');
    }

    public function getPriceAttribute()
    {
        $price = 0;

        foreach ($this->data as $booking_data) {
            $price += $booking_data->price;
        }

        return $price;
    }

    public function getBalanceAttribute()
    {
        $balance = 0;

        foreach ($this->data as $booking_data) {
            $balance += $booking_data->balance;
        }

        return $balance;
    }

    public function getDiscountAttribute()
    {
        $discount = 0;

        foreach ($this->data as $booking_data) {
            $discount += $booking_data->discount;
        }

        return $discount;
    }

    public function getRoomsAttribute()
    {
        $rooms = [];

        foreach ($this->data as $booking_data) {
            array_push($rooms, $booking_data->room_id);
        }

        if (count($rooms) === null) {
            return [];
        }

        return Room::whereIn('id', $rooms)->get();
    }
}
