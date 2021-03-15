<?php

namespace App;

use App\Data\Models\Church;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone_number', 'church_id', 'device_token', 'password',
    ];
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
//        static::creating(function (User $user) {
//            $user->church_id = Auth::user()->church_id;
//            $user->device_token = 'Invalid';
//        });
    }

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

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

}
