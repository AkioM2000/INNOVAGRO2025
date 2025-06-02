<?php

namespace App\Http\Controllers;

use App\Models\Afdeling;
use App\Models\Division;
use Illuminate\Http\Request;

class AfdelingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $afdelings = Afdeling::with('division')->paginate(10);
        return view('afdelings.index', compact('afdelings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        return view('afdelings.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'division_id' => 'required|exists:divisions,id'
        ]);

        Afdeling::create($validated);

        return redirect()->route('afdelings.index')
            ->with('success', 'Afdeling berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Afdeling $afdeling)
    {
        $divisions = Division::all();
        return view('afdelings.edit', compact('afdeling', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Afdeling $afdeling)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'division_id' => 'required|exists:divisions,id'
        ]);

        $afdeling->update($validated);

        return redirect()->route('afdelings.index')
            ->with('success', 'Afdeling berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Afdeling $afdeling)
    {
        $afdeling->delete();

        return redirect()->route('afdelings.index')
            ->with('success', 'Afdeling berhasil dihapus');
    }
}
