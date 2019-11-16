<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $fillable = ['name', 'lat', 'long', 'location'];
}
