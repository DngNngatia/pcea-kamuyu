<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['quote', 'uploaded_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
