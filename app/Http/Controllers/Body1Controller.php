<?php

namespace App\Http\Controllers;

use App\Models\Body1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Body1Controller extends Controller
{
    // Get the Body1 data
    public function show()
    {
        $Body1 = Body1::first();
        return response()->json($Body1);
    }

    // Store or update the Body1 section
    public function storeOrUpdate(Request $request)
    {
        $Body1 = Body1::first();

        $Img1 = $Body1->img1 ?? null;
        $Img2 = $Body1->img2 ?? null;

        if ($request->hasFile('img1')) {
            $file = $request->file('img1');
            $Img1 = time() . '_img1.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/Body1es'), $Img1);
        }

        if ($request->hasFile('img2')) {
            $file = $request->file('img2');
            $Img2 = time() . '_img2.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/Body1es'), $Img2);
        }

        $data = [
            'text1' => $request->input('text1'),
            'text2' => $request->input('text2'),
            'img1' => $Img1,
            'img2' => $Img2,
        ];

        if ($Body1) {
            $Body1->update($data);
        } else {
            $Body1 = Body1::create($data);
        }

        // Return full URLs if needed
        $Body1->img1 = $Body1->img1 ? url('uploads/Body1es/' . $Body1->img1) : null;
        $Body1->img2 = $Body1->img2 ? url('uploads/Body1es/' . $Body1->img2) : null;

        return response()->json($Body1);
    }
}
