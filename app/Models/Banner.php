<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'img1',
        'img2',
        'title',
        'subtitle',
        'app_store_link',
        'google_play_link',
        'login_link',
    ];
}
