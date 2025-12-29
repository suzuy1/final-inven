<?php

namespace App\Http\Controllers;

use App\Models\FundingSource;
use Illuminate\Http\Request;

class FundingSourceController extends Controller
{
    public function index()
    {
        $fundings = FundingSource::latest()->paginate(10);
        return view('pages.funding_sources.index', compact('fundings'));
    }

    public function create()
    {
        return view('pages.funding_sources.create');
    }

    public function store(Request $request)
{
    // Tampung hasil validasi ke variabel
    $validatedData = $request->validate([
        'code' => 'required|string|max:10|unique:funding_sources,code',
        'name' => 'required|string|max:255',
    ]);

    // Masukkan HANYA data yang sudah divalidasi (Token otomatis terbuang)
    FundingSource::create($validatedData);

    return redirect()->route('sumber-dana.index')->with('success', 'Sumber Dana berhasil ditambahkan.');
}

    public function edit(FundingSource $sumber_dana)
    {
        // Note: Parameter binding otomatis mencocokkan ID
        return view('pages.funding_sources.edit', compact('sumber_dana'));
    }

    public function update(Request $request, FundingSource $sumber_dana)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:funding_sources,code,' . $sumber_dana->id,
            'name' => 'required|string|max:255',
        ]);

        $sumber_dana->update($request->all());

        return redirect()->route('sumber-dana.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(FundingSource $sumber_dana)
    {
        $sumber_dana->delete();
        return redirect()->route('sumber-dana.index')->with('success', 'Data dihapus.');
    }
}