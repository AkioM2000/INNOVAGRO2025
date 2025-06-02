<?php

namespace App\Http\Controllers;

use App\Models\SpkPpbj;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Notifications\NewSpkPpbjNotification;

class SpkPpbjController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SpkPpbj::query();

        // Cek apakah ada parameter pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_dokumen', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhere('approver_name', 'like', "%{$search}%");
            });
        }

        $spkPpbj = $query->latest()->paginate(10)->withQueryString();
        
        return view('spk-ppbj.index', compact('spkPpbj'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil daftar admin
        $admins = \App\Models\User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->orWhere('is_admin', true)
        ->get(['id', 'name']);

        return view('spk-ppbj.create', compact('admins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_dokumen' => 'required|string|max:100|unique:spk_ppbjs,nomor_dokumen',
            'tanggal' => 'required|date',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'approver_name' => 'required|string|max:255',
        ]);
        
        // Tambahkan ID user yang mengunggah
        $validated['uploaded_by'] = auth()->id();

        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('spk-ppbj', 'public');
            $validated['lampiran'] = $path;
        }

        $spkPpbj = SpkPpbj::create($validated);

        // Kirim notifikasi ke admin yang dituju
        $approver = User::where('name', $validated['approver_name'])->first();
        
        if ($approver) {
            $uploaderName = auth()->user()->name;
            $approver->notify(new \App\Notifications\NewSpkPpbjNotification($spkPpbj, $uploaderName));
        }

        return redirect()->route('spk-ppbj.index')
            ->with('success', 'Data SPK & PPBJ berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SpkPpbj $spkPpbj)
    {
        // Tandai notifikasi sebagai sudah dibaca jika ada
        auth()->user()->unreadNotifications()
            ->where('type', 'App\\Notifications\\NewSpkPpbjNotification')
            ->where('data->spk_ppbj_id', $spkPpbj->id)
            ->update(['read_at' => now()]);
            
        return view('spk-ppbj.show', compact('spkPpbj'));
    }
    
    /**
     * Approve SPK & PPBJ
     */
    public function approve(SpkPpbj $spkPpbj)
    {
        if (auth()->user()->name === $spkPpbj->approver_name) {
            $spkPpbj->update([
                'approved_at' => now(),
                'approver_name' => auth()->user()->name
            ]);
            
            return redirect()->back()
                ->with('success', 'SPK & PPBJ berhasil disetujui');
        }
        
        return redirect()->back()
            ->with('error', 'Anda tidak memiliki izin untuk menyetujui dokumen ini');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SpkPpbj $spkPpbj)
    {
        // Ambil daftar admin
        $admins = \App\Models\User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->orWhere('is_admin', true)
        ->get(['id', 'name']);

        return view('spk-ppbj.edit', compact('spkPpbj', 'admins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpkPpbj $spkPpbj)
    {
        $rules = [
            'nomor_dokumen' => 'required|string|max:100|unique:spk_ppbjs,nomor_dokumen,' . $spkPpbj->id,
            'tanggal' => 'required|date',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'approver_name' => 'required|string|max:255',
        ];

        $validated = $request->validate($rules);

        if ($request->has('hapus_lampiran') && $spkPpbj->lampiran) {
            Storage::disk('public')->delete($spkPpbj->lampiran);
            $validated['lampiran'] = null;
        }

        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($spkPpbj->lampiran) {
                Storage::disk('public')->delete($spkPpbj->lampiran);
            }
            $path = $request->file('lampiran')->store('spk-ppbj', 'public');
            $validated['lampiran'] = $path;
        }

        $spkPpbj->update($validated);

        return redirect()->route('spk-ppbj.index')
            ->with('success', 'Data SPK & PPBJ berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpkPpbj $spkPpbj)
    {
        if ($spkPpbj->lampiran) {
            Storage::disk('public')->delete($spkPpbj->lampiran);
        }

        $spkPpbj->delete();

        return redirect()->route('spk-ppbj.index')
            ->with('success', 'Data SPK & PPBJ berhasil dihapus');
    }
}
