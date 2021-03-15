<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Quote extends Model
{
    protected $fillable = ['quote', 'uploaded_by'];

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function (Quote $quote) {
            $quote->uploaded_by = Auth::id();
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
