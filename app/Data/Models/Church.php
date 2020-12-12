<?php

namespace App\Data\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $fillable = ['name', 'lat', 'long', 'location'];

    public function users()
    {
        return $this->hasMany(User::class, 'church_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'church_id', 'id');
    }

    public function parties()
    {
        return $this->hasMany(Party::class, 'church_id', 'id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'church_id', 'id');
    }
}
