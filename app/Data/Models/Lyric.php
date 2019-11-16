<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Lyric extends Model
{
    protected $fillable = ['song_id', 'title', 'song_lyric', 'uploaded_by'];

    public function song()
    {
        return $this->belongsTo(Song::class, 'id', 'song_id');
    }
    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'id', 'uploaded_by');
    }
}
