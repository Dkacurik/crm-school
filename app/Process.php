<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = [
        'taskid', 'newtask', 'userid', 'inprogress', 'completed'
    ];
}
