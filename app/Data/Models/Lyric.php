<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lyric extends Model
{
    protected $fillable = ['song_id', 'title', 'song_lyric', 'uploaded_by'];

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function (Lyric $lyric) {
            $lyric->uploaded_by = Auth::id();
        });
    }

    public function song()
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
