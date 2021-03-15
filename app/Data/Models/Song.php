<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Song extends Model
{
    protected $fillable = ['title', 'singer', 'uploaded_by', 'file_path'];

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function (Song $song) {
            $song->uploaded_by = Auth::id();
        });
    }

    public function lyric()
    {
        return $this->belongsTo(Lyric::class, 'id', 'song_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

    public function scopeFilterBy($q, $filters)
    {

    }
}
