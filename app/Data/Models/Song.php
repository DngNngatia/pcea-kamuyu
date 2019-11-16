<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = ['title', 'singer', 'uploaded_by', 'file_path', 'lyric_id'];

    public function lyric()
    {
        return $this->belongsTo(Lyric::class, 'id', 'lyric_id');
    }

    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'id', 'uploaded_by');
    }

    public function scopeFilterBy($q,$filters){

    }
}
