<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Achieve;
use Illuminate\Http\Request;

class AchieveController extends Controller
{
    public function show()
    {
        $banner = Achieve::first();

        // Optional: Generate full URL for images
        if ($banner) {
            foreach (['back_img', 'mbl_img1', 'mbl_img2', 'mbl_img3', 'logo_img'] as $imgField) {
                if ($banner->$imgField) {
                    $banner->$imgField = url('uploads/Achieve/' . $banner->$imgField);
                }
            }
        }

        return response()->json($banner);
    }

    public function storeOrUpdate(Request $request)
    {
        $banner = Achieve::first();

        $data = $request->only([
            'title1',
            'title2'
        ]);

        // Handle image uploads
        foreach (['back_img', 'mbl_img1', 'mbl_img2', 'mbl_img3', 'logo_img'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . "_{$field}." . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/Achieve'), $filename);
                $data[$field] = $filename;
            } elseif ($banner) {
                $data[$field] = $banner->$field; // keep old value if not updated
            }
        }

        if ($banner) {
            $banner->update($data);
        } else {
            $banner = Achieve::create($data);
        }

        // Return full image URLs
        foreach (['back_img', 'mbl_img1', 'mbl_img2', 'mbl_img3', 'logo_img'] as $imgField) {
            if ($banner->$imgField) {
                $banner->$imgField = url('uploads/Achieve/' . $banner->$imgField);
            }
        }

        return response()->json($banner);
    }
}
