<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    protected $fillable = ['project_name', 'project_desc', 'project_status', 'uploaded_by', 'church_id', 'start', 'end'];
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function (Project $project) {
            $project->uploaded_by = Auth::id();
            $project->church_id = Auth::user()->church_id;
        });
    }
    protected $dates = [
      'start','end'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class, 'contribution_id', 'id');
    }

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'id');
    }
}
