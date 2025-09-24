<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeographyContent;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GeographyContentController extends Controller
{
    /**
     * Show geography content management page
     */
    public function index(): View
    {
        $contents = GeographyContent::ordered()->paginate(10);
        
        return view('admin.geography-content.index', compact('contents'));
    }

    /**
     * Show create geography content form
     */
    public function create(): View
    {
        return view('admin.geography-content.create');
    }

    /**
     * Store new geography content
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'icon' => 'nullable|string|max:255',
        ]);

        try {
            GeographyContent::create($validated);
            return redirect()->route('admin.geography-content.index')->with('success', 'Konten geografi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan konten geografi.')->withInput();
        }
    }

    /**
     * Show edit geography content form
     */
    public function edit(GeographyContent $geographyContent): View
    {
        return view('admin.geography-content.edit', compact('geographyContent'));
    }

    /**
     * Update geography content
     */
    public function update(Request $request, GeographyContent $geographyContent): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'icon' => 'nullable|string|max:255',
        ]);

        try {
            $geographyContent->update($validated);
            return redirect()->route('admin.geography-content.index')->with('success', 'Konten geografi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui konten geografi.')->withInput();
        }
    }

    /**
     * Delete geography content
     */
    public function destroy(GeographyContent $geographyContent): RedirectResponse
    {
        try {
            $geographyContent->delete();
            return redirect()->route('admin.geography-content.index')->with('success', 'Konten geografi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.geography-content.index')->with('error', 'Gagal menghapus konten geografi.');
        }
    }
}