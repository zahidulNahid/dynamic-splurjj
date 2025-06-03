<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Body1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'img1',
        'text1',
        'img2',
        'text2',
    ];
}
