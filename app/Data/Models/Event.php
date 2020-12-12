<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    protected $fillable = ['title', 'church_id', 'message', 'start_time', 'venue', 'user_id', 'contribution_id'];

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function (Event $event) {
            $event->user_id = Auth::id();
            $event->church_id = Auth::user()->church_id;
        });
    }

    public $dates = ['start_time'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class, 'contribution_id', 'id');
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }
}
