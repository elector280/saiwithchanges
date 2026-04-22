<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TinyMCEController extends Controller
{
    public function upload(Request $request)
    {
        // TinyMCE sends the file via the 'file' parameter
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Generate a unique file name
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store the file in the public/uploads/tinymce directory
            $path = $file->storeAs('uploads/tinymce', $filename, 'public');
            
            // Return the URL as required by TinyMCE
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
