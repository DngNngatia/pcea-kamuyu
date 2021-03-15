<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = ['church_id','title', 'message', 'venue', 'start_time', 'user_id', 'contribution_id'];

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
