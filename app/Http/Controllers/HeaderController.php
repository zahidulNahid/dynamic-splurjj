<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Header;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    // Get the Header (LandingPage) data
    public function show()
    {
        $header = Header::first();

        // Return full image URL if present
        if ($header && $header->img) {
            $header->img = url('uploads/headers/' . $header->img);
        }

        return response()->json($header);
    }


    public function storeOrUpdate(Request $request)
    {
        $header = Header::first();

        $img = $header->img ?? null;

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $img = time() . '_header.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/headers'), $img);
        }

        $data = [
            'item_name1' => $request->input('item_name1'),
            'itemlink1' => $request->input('itemlink1'),
            'item_name2' => $request->input('item_name2'),
            'itemlink2' => $request->input('itemlink2'),
            'login_link' => $request->input('login_link'),
            'app_store_link' => $request->input('app_store_link'),
            'google_play_link' => $request->input('google_play_link'),
            'img' => $img,
        ];

        if ($header) {
            $header->update($data);
        } else {
            $header = Header::create($data);
        }

        // Return full image URL
        $header->img = $header->img ? url('uploads/headers/' . $header->img) : null;

        return response()->json($header);
    }

}
