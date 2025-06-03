<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;
    protected $fillable = [
        'img',
        'item_name1',
        'itemlink1',
        'item_name2',
        'itemlink2',
        'login_link',
        'app_store_link',
        'google_play_link',
    ];
}
