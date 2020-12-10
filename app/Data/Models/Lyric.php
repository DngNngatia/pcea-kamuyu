<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    protected $fillable = ['song_id', 'title', 'song_lyric', 'uploaded_by'];

    public function song()
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
