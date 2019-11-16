<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['project_name', 'project_desc', 'project_status', 'uploaded_by', 'church_id', 'start', 'end'];

    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'id', 'uploaded_by');
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'project_id', 'id');
    }

    public function church()
    {
        return $this->belongsTo(Church::class, 'church_id', 'id');
    }
}
