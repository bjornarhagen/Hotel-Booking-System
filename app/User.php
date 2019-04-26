<?php

namespace App;

use Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Checks if the password is correct
     *
     * @param String $password
     * @return boolean
     */
    public function check_password(String $password): bool
    {
        return Auth::attempt(['email' => $this->email, 'password' => $password]);
    }

    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id')->withDefault(function ($image) {
            $image->url = config('app.user.default_image');
        });
    }

    public function getNameAttribute()
    {
        $name = $this->name_first . ' ' . $this->name_last;

        if ($this->name_prefix === null) {
            $name = $this->name_prefix . ' ' . $name;
        }

        return $name;
    }
}
