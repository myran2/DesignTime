<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * Get the tasks associated with this project
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
