<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{








    // public function updateEmail(Request $request)
    // {
    //     try {
    //         // Validate new email (must be unique except current user's email)
    //         $validated = $request->validate([
    //             'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
    //         ]);

    //         // Get authenticated user
    //         $user = Auth::user();

    //         if (!$user) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'User not authenticated.'
    //             ], 401);
    //         }

    //         // Update email
    //         $user->email = $validated['email'];
    //         if (method_exists($user, 'save')) {
    //             $user->save();
    //         } else {
    //             // If $user is not an Eloquent model, update via query builder
    //             DB::table('users')->where('id', $user->id)->update(['email' => $validated['email']]);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Email updated successfully.',
    //             'data'    => $user
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Error updating user email: ' . $e->getMessage());

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to update email.',
    //             'error'   => $e->getMessage()
    //         ], 500);
    //     }
    // }






    // public function updatePassword(Request $request)
    // {
    //     // return dd($request->all());
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'password' => 'required|string',
    //             'new_password' => 'required|string|min:6|confirmed', // uses new_password_confirmation
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Validation failed.',
    //                 'errors' => $validator->errors(),
    //             ], 400);
    //         }

    //         $user = Auth::user();

    //         // Check current password
    //         if (!Hash::check($request->password, $user->password)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'The current password is incorrect.',
    //             ], 403);
    //         }

    //         // Update to new password
    //         $user->password = Hash::make($request->password);
    //         $user->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Password updated successfully.',
    //         ], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Error updating password: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to update password.',
    //         ], 500);
    //     }
    // }



    public function storeOrUpdatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password'      => 'required|string',
                'new_password'          => 'required|string|min:6',
                'confirm_new_password'  => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors(),
                ], 400);
            }

            if ($request->new_password !== $request->confirm_new_password) {
                return response()->json([
                    'success' => false,
                    'message' => 'New password and confirmation do not match.',
                ], 400);
            }

            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The current password is incorrect.',
                ], 403);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the password.',
            ], 500);
        }
    }












    public function storeOrUpdate(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first.'
            ], 401);
        }

        try {
            $validated = $request->validate([
                'first_name'   => 'nullable|string|max:255',
                'last_name'    => 'nullable|string|max:255',
                'phone'        => 'nullable|string|max:255',
                'email'        => 'nullable|email|max:255|unique:users,email,' . Auth::id(),
                'country'      => 'nullable|string|max:255',
                'city'         => 'nullable|string|max:255',
                'profile_pic'  => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240', // 10MB
            ]);

            $user = Auth::user();

            // Update fields
            $user->first_name = $validated['first_name'] ?? $user->first_name;
            $user->last_name  = $validated['last_name'] ?? $user->last_name;
            $user->phone      = $validated['phone'] ?? $user->phone;
            $user->email      = $validated['email'] ?? $user->email;
            $user->country    = $validated['country'] ?? $user->country;
            $user->city       = $validated['city'] ?? $user->city;

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                // Delete old profile picture if exists
                if ($user->profile_pic && file_exists(public_path('uploads/ProfilePics/' . $user->profile_pic))) {
                    unlink(public_path('uploads/ProfilePics/' . $user->profile_pic));
                }

                $profilePic = $request->file('profile_pic');
                $profilePicName = time() . '_profile.' . $profilePic->getClientOriginalExtension();
                $profilePic->move(public_path('uploads/ProfilePics'), $profilePicName);
                $user->profile_pic = $profilePicName;

                // Alternative using Storage (future-proof):
                // $profilePicName = $profilePic->storeAs('profile_pics', $profilePicName, 'public');
                // $user->profile_pic = basename($profilePicName);
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'data'    => [
                    'first_name'  => $user->first_name,
                    'last_name'   => $user->last_name,
                    'phone'       => $user->phone,
                    'email'       => $user->email,
                    'country'     => $user->country,
                    'city'        => $user->city,
                    'profile_pic' => $user->profile_pic
                        ? url('uploads/ProfilePics/' . $user->profile_pic)
                        : null,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating user profile: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }







    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10248',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $imageName = time() . '_logo.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/logos');

            // Get existing settings record or create new one
            $setting = Setting::first();

            // Delete old logo file if it exists
            if ($setting && $setting->logo && file_exists(public_path($setting->logo))) {
                unlink(public_path($setting->logo));
            }

            // Move the new file
            $file->move($destinationPath, $imageName);

            // Save to database
            if (!$setting) {
                $setting = Setting::create(['logo' => 'uploads/logos/' . $imageName]);
            } else {
                $setting->update(['logo' => 'uploads/logos/' . $imageName]);
            }

            return back()->with('success', 'Logo updated successfully.');
        }

        return back()->with('error', 'No logo file uploaded.');
    }

    public function updateProfilePic(Request $request)
    {
        $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10248',
        ]);

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $imageName = time() . '_profile.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/profiles');

            // Get or create settings record
            $setting = Setting::first();

            // Delete old profile picture if it exists
            if ($setting && $setting->profile_pic && file_exists(public_path($setting->profile_pic))) {
                unlink(public_path($setting->profile_pic));
            }

            // Move the new profile picture
            $file->move($destinationPath, $imageName);

            // Save to database
            if (!$setting) {
                $setting = Setting::create(['profile_pic' => 'uploads/profiles/' . $imageName]);
            } else {
                $setting->update(['profile_pic' => 'uploads/profiles/' . $imageName]);
            }

            return back()->with('success', 'Profile picture updated successfully.');
        }

        return back()->with('error', 'No profile picture file uploaded.');
    }
}
