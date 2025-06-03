<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achieve extends Model
{
    use HasFactory;
    protected $fillable = [
        'back_img',
        'mbl_img1',
        'mbl_img2',
        'mbl_img3',
        'title1',
        'title2',
        'logo_img',
    ];
}
