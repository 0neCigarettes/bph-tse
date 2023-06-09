<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = true;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role', 'status'
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

    public static function getTechAvailable()
    {
        return User::where('role', 2)
            ->where('status', 0);
    }

    public static function getUserInactives()
    {
        return User::where('status', 1)->where('role', '!=', 0);
    }

    public static function getUserActives()
    {
        return User::where('status', 0)->where('role', '!=', 0);
    }
}
