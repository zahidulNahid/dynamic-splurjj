<?php

namespace App\Http\Controllers;

use App\Models\MobileMockUp;
use Illuminate\Http\Request;

class MobileMockUpController extends Controller
{
    // Show the first mobile mockup record
    public function show()
    {
        $mockup = MobileMockUp::first();

        // Append full image URLs if available
        if ($mockup) {
            $mockup->back_img = $mockup->back_img ? url('uploads/mobilemockup/' . $mockup->back_img) : null;
            $mockup->mbl_img1 = $mockup->mbl_img1 ? url('uploads/mobilemockup/' . $mockup->mbl_img1) : null;
            $mockup->mbl_img2 = $mockup->mbl_img2 ? url('uploads/mobilemockup/' . $mockup->mbl_img2) : null;
        }

        return response()->json($mockup);
    }

    // Store or update the mockup
    public function storeOrUpdate(Request $request)
    {
        $mockup = MobileMockUp::first();

        // Preserve existing images
        $back_img = $mockup->back_img ?? null;
        $mbl_img1 = $mockup->mbl_img1 ?? null;
        $mbl_img2 = $mockup->mbl_img2 ?? null;

        // Handle uploads
        if ($request->hasFile('back_img')) {
            $file = $request->file('back_img');
            $back_img = time() . '_back_img.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/mobilemockup'), $back_img);
        }

        if ($request->hasFile('mbl_img1')) {
            $file = $request->file('mbl_img1');
            $mbl_img1 = time() . '_mbl_img1.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/mobilemockup'), $mbl_img1);
        }

        if ($request->hasFile('mbl_img2')) {
            $file = $request->file('mbl_img2');
            $mbl_img2 = time() . '_mbl_img2.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/mobilemockup'), $mbl_img2);
        }

        // Prepare data for insert/update
        $data = [
            'title1' => $request->input('title1'),
            'title2' => $request->input('title2'),
            'title3' => $request->input('title3'),
            'color' => $request->input('color'),
            'back_img' => $back_img,
            'mbl_img1' => $mbl_img1,
            'mbl_img2' => $mbl_img2,
        ];

        if ($mockup) {
            $mockup->update($data);
        } else {
            $mockup = MobileMockUp::create($data);
        }

        // Append full image URLs before returning
        $mockup->back_img = $mockup->back_img ? url('uploads/mobilemockup/' . $mockup->back_img) : null;
        $mockup->mbl_img1 = $mockup->mbl_img1 ? url('uploads/mobilemockup/' . $mockup->mbl_img1) : null;
        $mockup->mbl_img2 = $mockup->mbl_img2 ? url('uploads/mobilemockup/' . $mockup->mbl_img2) : null;

        return response()->json($mockup);
    }
}
