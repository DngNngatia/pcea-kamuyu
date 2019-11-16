<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = ['church_id','title', 'message', 'venue', 'start_time', 'user_id', 'contribution_id'];

    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class, 'id', 'contribution_id');
    }
}
