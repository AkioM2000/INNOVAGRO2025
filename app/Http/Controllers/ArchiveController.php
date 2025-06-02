<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = Archive::with('category')->latest()->paginate(10);
        return view('archives.index', compact('archives'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('archives.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'file' => 'required|mimes:pdf,doc,docx|max:2048'
        ]);

        $file = $request->file('file');
        $filePath = $file->store('archives', 'public');

        Archive::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'file_path' => $filePath
        ]);

        return redirect()->route('archives.index')->with('success', 'Arsip berhasil ditambahkan');
    }

    public function show(Archive $archive)
    {
        return view('archives.show', compact('archive'));
    }

    public function edit(Archive $archive)
    {
        $categories = Category::all();
        return view('archives.edit', compact('archive', 'categories'));
    }

    public function update(Request $request, Archive $archive)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            Storage::disk('public')->delete($archive->file_path);

            // Store new file
            $file = $request->file('file');
            $filePath = $file->store('archives', 'public');
            $data['file_path'] = $filePath;
        }

        $archive->update($data);

        return redirect()->route('archives.index')->with('success', 'Arsip berhasil diperbarui');
    }

    public function destroy(Archive $archive)
    {
        // Delete file
        Storage::disk('public')->delete($archive->file_path);

        $archive->delete();

        return redirect()->route('archives.index')->with('success', 'Arsip berhasil dihapus');
    }
}
