<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class UpdateController extends Controller
{
    // Show the authenticated user's email
    public function show()
    {
        try {
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'data' => [
                    'email' => $user->email,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user information.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update the authenticated user's profile
    public function UpdateEP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:users,email,',
                'password' => 'required|string|min:8',
            ]);

            $user = Auth::user();

            $user->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'data' => [
                    'email' => $user->email,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Profile update failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
