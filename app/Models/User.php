<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all tasks that this user is assigned to
     */
    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task')->withPivot('sort_order');
    }

    public function projects()
    {
        return $this->hasMany('App\Models\Project', 'creator_id');
    }
}
