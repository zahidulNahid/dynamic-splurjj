<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $fillable = [
        'mbl_img1',
        'mbl_img2',
        'mbl_img3',
        'mbl_img4',
        'title1',
        'all_mbl_img',
        'title2',
        'color',
    ];
}
