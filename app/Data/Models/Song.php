<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = ['title', 'singer', 'uploaded_by', 'file_path'];

    public function lyric()
    {
        return $this->belongsTo(Lyric::class, 'id', 'song_id');
    }

//    public function uploaded_by()
//    {
//        return $this->belongsTo(User::class, 'uploaded_by', 'id');
//    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

    public function scopeFilterBy($q, $filters)
    {

    }
}
