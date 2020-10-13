<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_User extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'task_id'];
    public $timestamps = false;
}
