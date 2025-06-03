<?php

namespace App\Http\Controllers;

use App\Models\Body2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Body2Controller extends Controller
{
    public function show()
    {
        $Body2 = Body2::first();
        return response()->json($Body2);
    }

    // Store or update the Body2 section
    public function storeOrUpdate(Request $request)
    {
        $Body2 = Body2::first();

        $Img1 = $Body2->img1 ?? null;


        if ($request->hasFile('img1')) {
            $file = $request->file('img1');
            $Img1 = time() . '_img1.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/Body2es'), $Img1);
        }


        $data = [
            'text1' => $request->input('text1'),
            'img1' => $Img1,
        ];

        if ($Body2) {
            $Body2->update($data);
        } else {
            $Body2 = Body2::create($data);
        }

        // Return full URLs if needed
        $Body2->img1 = $Body2->img1 ? url('uploads/Body2es/' . $Body2->img1) : null;

        return response()->json($Body2);
    }
}
