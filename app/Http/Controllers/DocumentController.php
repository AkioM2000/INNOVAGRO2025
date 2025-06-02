<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use App\Models\Afdeling;
use App\Notifications\DocumentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = Document::with(['category', 'user', 'afdeling']);

        // Search by title, description, or file number
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhere('file_number', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by afdeling
        if ($request->has('afdeling_id') && $request->afdeling_id) {
            $query->where('afdeling_id', $request->afdeling_id);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $documents = $query->latest()->paginate(10);
        $categories = Category::all();
        $afdelings = Afdeling::all();
        $users = \App\Models\User::all();

        return view('documents.index', compact('documents', 'categories', 'afdelings', 'users'));
    }

    public function create()
    {
        $categories = Category::all();
        $afdelings = Afdeling::all();
        return view('documents.create', compact('categories', 'afdelings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'category_id' => 'required|exists:categories,id',
            'afdeling_id' => 'required|exists:afdelings,id'
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

            // Get file size before storing
            $fileSize = $file->getSize() ?: 0;
            $fileType = $file->getClientOriginalExtension();

            // Store file
            $path = $file->storeAs('documents', $fileName, 'public');

            if (!$path) {
                return back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
            }

            // Generate unique file number
            $afdeling = \App\Models\Afdeling::find($validated['afdeling_id']);
            $category = \App\Models\Category::find($validated['category_id']);

            // Get the current date in Ymd format
            $date = now()->format('Ymd');

            // Get the last document number for today
            $lastDocument = Document::whereDate('created_at', today())
                ->orderBy('id', 'desc')
                ->first();

            // Generate a 4-digit sequence number
            $sequence = '0001';
            if ($lastDocument && $lastDocument->file_number) {
                // Extract the sequence part from the last document number
                $lastSequence = substr($lastDocument->file_number, -4);
                $sequence = str_pad((intval($lastSequence) + 1), 4, '0', STR_PAD_LEFT);
            }

            // Create the file number: AFD-CAT-DATE-SEQUENCE
            $fileNumber = $afdeling->code . '-' . $category->code . '-' . $date . '-' . $sequence;

            $document = Document::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'afdeling_id' => $validated['afdeling_id'],
                'file_path' => $path,
                'file_name' => $fileName,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'user_id' => Auth::id(),
                'file_number' => $fileNumber
            ]);

            return redirect()->route('documents.index')
                ->with('success', 'Dokumen berhasil diunggah.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error uploading document: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengunggah dokumen. Silakan coba lagi.');
        }
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $categories = Category::all();
        $afdelings = Afdeling::all();
        return view('documents.edit', compact('document', 'categories', 'afdelings'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'category_id' => 'required|exists:categories,id',
            'afdeling_id' => 'required|exists:afdelings,id'
        ]);

        try {
            $data = [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'afdeling_id' => $validated['afdeling_id']
            ];

            if ($request->hasFile('file')) {
                // Delete old file
                if ($document->file_path) {
                    Storage::disk('public')->delete($document->file_path);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

                // Get file size before storing
                $fileSize = $file->getSize() ?: 0;
                $fileType = $file->getClientOriginalExtension();

                // Store new file
                $path = $file->storeAs('documents', $fileName, 'public');

                if (!$path) {
                    return back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
                }

                $data['file_path'] = $path;
                $data['file_name'] = $fileName;
                $data['file_type'] = $fileType;
                $data['file_size'] = $fileSize;
            }

            $document->update($data);

            return redirect()->route('documents.index')
                ->with('success', 'Dokumen berhasil diperbarui.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating document: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui dokumen. Silakan coba lagi.');
        }
    }

    public function destroy(Document $document)
    {
        try {
            // Store the success message in session before deletion
            session()->flash('success', 'Dokumen berhasil dihapus.');

            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $document->delete();

            return redirect()->route('documents.index');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting document: ' . $e->getMessage());
            return redirect()->route('documents.index')
                ->with('error', 'Terjadi kesalahan saat menghapus dokumen. Silakan coba lagi.');
        }
    }

    public function download(Document $document)
    {
        try {
            $path = storage_path('app/public/' . $document->file_path);

            if (!file_exists($path)) {
                return back()->with('error', 'File tidak ditemukan.');
            }

            return response()->download($path, $document->file_name);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error downloading document: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengunduh dokumen. Silakan coba lagi.');
        }
    }
}
