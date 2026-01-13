<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Specify the table name, since the table name is plural and different from the default (activities)
    protected $table = 'activities';

    // Define which fields are mass assignable (to protect against mass-assignment vulnerabilities)
    protected $fillable = [
        'subject',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
    ];
}
