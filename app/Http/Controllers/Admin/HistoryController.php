<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $histories = History::active()
            ->ordered()
            ->get()
            ->groupBy(['category', 'subcategory']);

        return view('admin.history.index', compact('histories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'Prasejarah Indonesia',
            'Kerajaan', 
            'Sejarah Nasional Indonesia',
            'Kemerdekaan'
        ];

        $subcategories = [
            'Prasejarah Indonesia' => [
                'Pengertian',
                'Geologi', 
                'Periodisasi',
                'Sistem Kepercayaan'
            ],
            'Kerajaan' => [
                'Masa Sejarah Awal / Hindu-Buddha',
                'Masa Kerajaan Islam'
            ],
            'Sejarah Nasional Indonesia' => [
                'Era Kolonialisme / penjajahan',
                'Era perjuangan Kedaerahan',
                'Era kebangkitan nasional'
            ],
            'Kemerdekaan' => [
                'Masa Kemerdekaan',
                'Masa Orde Baru',
                'Masa Reformasi & Era Kontemporer'
            ]
        ];

        $subSubcategories = [
            'Periodisasi' => [
                'Zaman paleolitikum',
                'Zaman neolitikum',
                'Zaman Megalitikum',
                'Zaman Perunggu',
                'Zaman Besi',
                'Rangkuman'
            ],
            'Era Kolonialisme / penjajahan' => [
                'Portugis',
                'Inggris',
                'Belanda',
                'Jepang'
            ],
            'Era perjuangan Kedaerahan' => [
                'Perang Maluku',
                'Perang Palembang',
                'Perang Padri',
                'Perang Diponegoro',
                'Perang Bali',
                'Perang Banjar',
                'Perang Aceh'
            ],
            'Era kebangkitan nasional' => [
                'Boedi Oetomo',
                'Sumpah Pemoeda'
            ]
        ];

        return view('admin.history.create', compact('categories', 'subcategories', 'subSubcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'sub_subcategory' => 'nullable|string|max:255',
            'order_index' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        History::create($validated);

        return redirect()->route('admin.history.index')
            ->with('success', 'Data sejarah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        return view('admin.history.show', compact('history'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        $categories = [
            'Prasejarah Indonesia',
            'Kerajaan', 
            'Sejarah Nasional Indonesia',
            'Kemerdekaan'
        ];

        $subcategories = [
            'Prasejarah Indonesia' => [
                'Pengertian',
                'Geologi', 
                'Periodisasi',
                'Sistem Kepercayaan'
            ],
            'Kerajaan' => [
                'Masa Sejarah Awal / Hindu-Buddha',
                'Masa Kerajaan Islam'
            ],
            'Sejarah Nasional Indonesia' => [
                'Era Kolonialisme / penjajahan',
                'Era perjuangan Kedaerahan',
                'Era kebangkitan nasional'
            ],
            'Kemerdekaan' => [
                'Masa Kemerdekaan',
                'Masa Orde Baru',
                'Masa Reformasi & Era Kontemporer'
            ]
        ];

        $subSubcategories = [
            'Periodisasi' => [
                'Zaman paleolitikum',
                'Zaman neolitikum',
                'Zaman Megalitikum',
                'Zaman Perunggu',
                'Zaman Besi',
                'Rangkuman'
            ],
            'Era Kolonialisme / penjajahan' => [
                'Portugis',
                'Inggris',
                'Belanda',
                'Jepang'
            ],
            'Era perjuangan Kedaerahan' => [
                'Perang Maluku',
                'Perang Palembang',
                'Perang Padri',
                'Perang Diponegoro',
                'Perang Bali',
                'Perang Banjar',
                'Perang Aceh'
            ],
            'Era kebangkitan nasional' => [
                'Boedi Oetomo',
                'Sumpah Pemoeda'
            ]
        ];

        return view('admin.history.edit', compact('history', 'categories', 'subcategories', 'subSubcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'sub_subcategory' => 'nullable|string|max:255',
            'order_index' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $history->update($validated);

        return redirect()->route('admin.history.index')
            ->with('success', 'Data sejarah berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        $history->delete();

        return redirect()->route('admin.history.index')
            ->with('success', 'Data sejarah berhasil dihapus.');
    }

    /**
     * Handle image upload from Summernote
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('history-images', $filename, 'public');
            
            return response()->json([
                'url' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
