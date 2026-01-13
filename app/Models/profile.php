<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'gender',
        'address',
        'parent_name',
        'contact_no',
    ];
}
