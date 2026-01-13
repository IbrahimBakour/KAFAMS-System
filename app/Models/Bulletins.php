<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletins extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulletin_title',
        'bulletin_image',
        'bulletin_desc',
        'bulletin_category'
    ];
}
