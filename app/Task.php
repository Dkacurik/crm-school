<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'content', 'userid', 'worktaskid', 'newtask', 'completed', 'inprogress', 'taskfrom', 'deadline'
    ];
}
