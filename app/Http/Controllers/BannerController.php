<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    // Get the first banner (like landing page content)
    public function show()
    {
        $banner = Banner::first();

        // Append full image URLs if images are available
        if ($banner) {
            $banner->img1 = $banner->img1 ? url('uploads/banners/' . $banner->img1) : null;
            $banner->img2 = $banner->img2 ? url('uploads/banners/' . $banner->img2) : null;
        }

        return response()->json($banner);
    }

    // Store or update the banner content
    public function storeOrUpdate(Request $request)
    {
        $banner = Banner::first();

        $img1 = $banner->img1 ?? null;
        $img2 = $banner->img2 ?? null;

        if ($request->hasFile('img1')) {
            $file1 = $request->file('img1');
            $img1 = time() . '_img1.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('uploads/banners'), $img1);
        }

        if ($request->hasFile('img2')) {
            $file2 = $request->file('img2');
            $img2 = time() . '_img2.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('uploads/banners'), $img2);
        }

        $data = [
            'img1' => $img1,
            'img2' => $img2,
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'app_store_link' => $request->input('app_store_link'),
            'google_play_link' => $request->input('google_play_link'),
            'login_link' => $request->input('login_link'),
        ];

        if ($banner) {
            $banner->update($data);
        } else {
            $banner = Banner::create($data);
        }

        // Append full URLs before returning
        $banner->img1 = $banner->img1 ? url('uploads/banners/' . $banner->img1) : null;
        $banner->img2 = $banner->img2 ? url('uploads/banners/' . $banner->img2) : null;

        return response()->json($banner);
    }



}
