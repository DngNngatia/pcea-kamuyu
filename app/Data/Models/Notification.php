<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $fillable = ['title', 'message', 'send_at', 'created_by'];

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function (Notification $notification) {
            $notification->created_by = Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
