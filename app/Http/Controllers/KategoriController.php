<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate(['search' => ['nullable', 'string', 'max:100']]);
        $search = trim($filters['search'] ?? '');
        $categories = KategoriSarana::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('nama_kategori', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            }))
            ->orderBy('nama_kategori')
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('categories', 'search'));
    }

    public function create(): View
    {
        return view('kategori.form', ['category' => new KategoriSarana]);
    }

    public function store(Request $request): RedirectResponse
    {
        KategoriSarana::create($request->validate([
            'nama_kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]));

        return to_route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(KategoriSarana $kategori): View
    {
        return view('kategori.form', ['category' => $kategori]);
    }

    public function update(Request $request, KategoriSarana $kategori): RedirectResponse
    {
        $kategori->update($request->validate([
            'nama_kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]));

        return to_route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriSarana $kategori): RedirectResponse
    {
        if ($kategori->saranas()->exists()) {
            throw ValidationException::withMessages([
                'kategori' => 'Kategori tidak dapat dihapus karena masih digunakan oleh sarana.',
            ]);
        }

        $kategori->delete();

        return to_route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
