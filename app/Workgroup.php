<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workgroup extends Model
{
    protected $fillable = [
        'workid', 'userpercentage', 'userid'
    ];
}
