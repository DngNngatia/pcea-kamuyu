<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = ['church_id','event_id', 'project_id', 'title', 'message', 'amount', 'deadline', 'payment_method'];
}
