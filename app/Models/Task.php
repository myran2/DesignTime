<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'description', 'status', 'creator_id', 'project_id', 'hide'];

    /**
     * Get all users assigned to this task
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    /**
     * Get this task's parent project
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
