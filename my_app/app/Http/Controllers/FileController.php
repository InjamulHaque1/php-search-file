<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    // Show homepage with files
    public function index()
    {
        $files = File::latest()->get();
        return view('home', compact('files'));
    }

    // Handle file upload
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:20480', // max 20MB
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName(); // Add timestamp to avoid duplicate names
        $destinationPath = public_path('uploads'); // full path to /public/uploads

        // Create folder if it doesn’t exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }   

        // Move uploaded file to /public/uploads
        $file->move($destinationPath, $filename);

        // Save info to DB
        File::create([
            'filename' => $filename,
            'path' => 'uploads/' . $filename,
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    // Search page
    public function searchPage()
    {
        return view('search');
    }

    // Handle file search
    public function search(Request $request)
    {
        $query = $request->input('q');
        $files = File::where('filename', 'like', "%{$query}%")->get();

        return view('search', compact('files', 'query'));
    }

        // Delete file
    public function destroy($id)
    {
        $file = File::findOrFail($id);

        $filePath = public_path($file->path); // full path: /public/uploads/filename.jpg

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }


}
