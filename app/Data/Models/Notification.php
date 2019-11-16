<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'message', 'send_at', 'created_by'];

    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }
}
