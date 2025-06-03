<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function show()
    {
        $msg = ContactMessage::first();
        return response()->json($msg);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'email' => 'required',
            'message' => 'nullable|string',
        ]);

        $contact = ContactMessage::create($validated);

        // Send email to abubdcalling@gmail.com
        Mail::to('abubdcalling@gmail.com')->send(new ContactMessageMail($contact));

        return response()->json([
            'message' => 'Contact message saved successfully.',
            'last_inserted_id' => $contact->id,
            'data' => $contact
        ], 201);
    }

}
