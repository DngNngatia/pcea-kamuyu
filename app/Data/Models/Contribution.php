<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Contribution extends Model
{
    protected $fillable = ['church_id', 'event_id', 'project_id', 'title', 'message', 'amount', 'deadline', 'payment_method'];

    protected $dates = ['deadline'];

    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function (Contribution $contribution) {
            $contribution->church_id = Auth::user()->church_id;
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'id');
    }

}
