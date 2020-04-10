<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $fillable = [
        'event',
        'from',
        'to',
        'mondays',
        'tuesdays',
        'wednesdays',
        'thursdays',
        'fridays',
        'saturdays',
        'sundays'
    ];
    protected $attributes = [
        'mondays' => 0,
        'tuesdays' => 0,
        'wednesdays' => 0,
        'thursdays' => 0,
        'fridays' => 0,
        'saturdays' => 0,
        'sundays' => 0
    ];

}
