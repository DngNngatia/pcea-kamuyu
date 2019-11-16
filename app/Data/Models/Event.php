<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title','church_id', 'message', 'start_time', 'venue', 'user_id', 'contribution_id'];

    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function contribution()
    {
        return $this->belongsTo(User::class, 'id', 'contribution_id');
    }
}
