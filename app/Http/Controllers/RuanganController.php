<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use App\Models\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RuanganController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'id_kategori' => ['nullable', 'integer', 'exists:kategori_saranas,id'],
        ]);
        $search = trim($filters['search'] ?? '');
        $categoryId = $filters['id_kategori'] ?? null;
        $rooms = Ruangan::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('kode_ruangan', 'like', "%{$search}%")
                    ->orWhere('nama_ruangan', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            }))
            ->when($categoryId, fn ($query) => $query->whereHas('saranas', fn ($query) => $query->where('id_kategori', $categoryId)))
            ->withCount('saranas')
            ->orderBy('nama_ruangan')
            ->paginate(10)
            ->withQueryString();

        return view('ruangan.index', [
            'rooms' => $rooms,
            'search' => $search,
            'categoryId' => $categoryId,
            'categories' => KategoriSarana::orderBy('nama_kategori')->get(),
        ]);
    }

    public function create(): View
    {
        return view('ruangan.form', ['room' => new Ruangan]);
    }

    public function store(Request $request): RedirectResponse
    {
        Ruangan::create($request->validate([
            'kode_ruangan' => ['required', 'string', 'max:50', 'unique:ruangans,kode_ruangan'],
            'nama_ruangan' => ['required', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:100'],
        ]));

        return to_route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan): View
    {
        return view('ruangan.form', ['room' => $ruangan]);
    }

    public function update(Request $request, Ruangan $ruangan): RedirectResponse
    {
        $ruangan->update($request->validate([
            'kode_ruangan' => ['required', 'string', 'max:50', 'unique:ruangans,kode_ruangan,'.$ruangan->id],
            'nama_ruangan' => ['required', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:100'],
        ]));

        return to_route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan): RedirectResponse
    {
        if ($ruangan->saranas()->exists() || $ruangan->laporan()->exists()) {
            throw ValidationException::withMessages([
                'ruangan' => 'Ruangan tidak dapat dihapus karena masih digunakan oleh sarana atau laporan.',
            ]);
        }

        $ruangan->delete();

        return to_route('ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
