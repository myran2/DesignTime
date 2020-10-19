<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'creator_id'];

    /**
     * Get the tasks associated with this project
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User');
    }
}
