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
    protected $fillable = ['user_id', 'name', 'description', 'status', 'creator_id'];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
