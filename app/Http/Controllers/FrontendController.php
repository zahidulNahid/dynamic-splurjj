<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Achieve;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Body1;
use App\Models\Body2;
use App\Models\Feature;
use App\Models\Footer;
use App\Models\Header;
use App\Models\Hero;
use App\Models\MobileMockUp;

class FrontendController extends Controller
{
    public function getAllData()
    {
        $data = [
            'home' => Banner::all(),
            'feature' => Feature::all(),
            'footer' => Footer::all(),
            'header' => Header::all(),
            'mobile_mockup' => MobileMockUp::all(),
            'achive'=>Achieve::all(),
            'banner' => Banner::all(),
            'hero'=>Hero::all(),
            'body1'=>Body1::all(),
            'body2'=>Body2::all(),
            
        ];

        return response()->json($data);
    }
}
