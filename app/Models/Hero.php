<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $fillable = [
        'back_img',
        'mbl_img',
        'title',
        'sub_title',
        'link1',
        'link2'
    ];
}
