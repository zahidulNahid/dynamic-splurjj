<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    // Get the hero data
    public function show()
    {
        $hero = Hero::first();
        return response()->json($hero);
    }

    // Store or update the hero section
    public function storeOrUpdate(Request $request)
    {
        $hero = Hero::first();

        $backImgName = $hero->back_img ?? null;
        $mblImgName = $hero->mbl_img ?? null;

        if ($request->hasFile('back_img')) {
            $file = $request->file('back_img');
            $backImgName = time() . '_back.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/heroes'), $backImgName);
        }

        if ($request->hasFile('mbl_img')) {
            $file = $request->file('mbl_img');
            $mblImgName = time() . '_mbl.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/heroes'), $mblImgName);
        }

        $data = [
            'title' => $request->input('title'),
            'sub_title' => $request->input('sub_title'),
            'link1' => $request->input('link1'),
            'link2' => $request->input('link2'),
            'back_img' => $backImgName,
            'mbl_img' => $mblImgName,
        ];

        if ($hero) {
            $hero->update($data);
        } else {
            $hero = Hero::create($data);
        }

        // Return full URLs if needed
        $hero->back_img = $hero->back_img ? url('uploads/heroes/' . $hero->back_img) : null;
        $hero->mbl_img = $hero->mbl_img ? url('uploads/heroes/' . $hero->mbl_img) : null;

        return response()->json($hero);
    }

}
