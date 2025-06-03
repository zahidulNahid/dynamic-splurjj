<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Footer;

class FooterController extends Controller
{
    // Get the settings
    public function show()
    {
        $setting = Footer::first();

        if ($setting && $setting->logo) {
            $setting->logo = url('uploads/settings/' . $setting->logo);
        }

        return response()->json($setting);
    }

    // Store or update settings
    public function storeOrUpdate(Request $request)
    {
        $setting = Footer::first();

        $logo = $setting->logo ?? null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = time() . '_logo.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $logo);
        }

        $data = [
            'color' => $request->input('color'),
            'login_link' => $request->input('login_link'),
            'app_store_link' => $request->input('app_store_link'),
            'google_play_link' => $request->input('google_play_link'),
            'first_text' => $request->input('first_text'),
            'first_text_color' => $request->input('first_text_color'),
            'second_text' => $request->input('second_text'),
            'second_text_color' => $request->input('second_text_color'),
            'third_text' => $request->input('third_text'),
            'third_text_color' => $request->input('third_text_color'),
            'logo' => $logo,
        ];

        if ($setting) {
            $setting->update($data);
        } else {
            $setting = Footer::create($data);
        }

        // Return full logo URL
        $setting->logo = $setting->logo ? url('uploads/settings/' . $setting->logo) : null;

        return response()->json($setting);
    }
}
