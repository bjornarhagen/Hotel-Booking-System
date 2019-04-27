<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public function brand_logo()
    {
        return $this->hasOne('App\Image', 'id', 'brand_logo_id')->withDefault(function ($image) {
            $image->url = '/images/default-hotel.svg';
            $image->is_default = true;
        });
    }

    public function brand_icon()
    {
        return $this->hasOne('App\Image', 'id', 'brand_icon_id')->withDefault(function ($image) {
            $image->url = '/images/default-hotel.svg';
            $image->is_default = true;
        });
    }
}
