<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use App\Models\Ruangan;
use App\Models\Sarana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SaranaController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'id_kategori' => ['nullable', 'integer', 'exists:kategori_saranas,id'],
        ]);
        $search = trim($filters['search'] ?? '');
        $categoryId = $filters['id_kategori'] ?? null;
        $facilities = Sarana::query()
            ->with(['kategori', 'ruangan'])
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('kode_sarana', 'like', "%{$search}%")
                    ->orWhere('nama_sarana', 'like', "%{$search}%");
            }))
            ->when($categoryId, fn ($query) => $query->where('id_kategori', $categoryId))
            ->orderBy('nama_sarana')
            ->paginate(10)
            ->withQueryString();

        return view('sarana.index', [
            'facilities' => $facilities,
            'search' => $search,
            'categoryId' => $categoryId,
            'categories' => KategoriSarana::orderBy('nama_kategori')->get(),
        ]);
    }

    public function create(): View
    {
        return view('sarana.form', [
            'facility' => new Sarana,
            'categories' => KategoriSarana::orderBy('nama_kategori')->get(),
            'rooms' => Ruangan::orderBy('nama_ruangan')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Sarana::create($this->validatedData($request));

        return to_route('sarana.index')->with('success', 'Sarana berhasil ditambahkan.');
    }

    public function edit(Sarana $sarana): View
    {
        return view('sarana.form', [
            'facility' => $sarana,
            'categories' => KategoriSarana::orderBy('nama_kategori')->get(),
            'rooms' => Ruangan::orderBy('nama_ruangan')->get(),
        ]);
    }

    public function update(Request $request, Sarana $sarana): RedirectResponse
    {
        $sarana->update($this->validatedData($request, $sarana));

        return to_route('sarana.index')->with('success', 'Sarana berhasil diperbarui.');
    }

    public function destroy(Sarana $sarana): RedirectResponse
    {
        if ($sarana->laporan()->exists() || $sarana->beritaAcara()->exists()) {
            throw ValidationException::withMessages([
                'sarana' => 'Sarana tidak dapat dihapus karena sudah memiliki laporan atau berita acara.',
            ]);
        }

        $sarana->delete();

        return to_route('sarana.index')->with('success', 'Sarana berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Sarana $sarana = null): array
    {
        return $request->validate([
            'kode_sarana' => ['required', 'string', 'max:50', 'unique:saranas,kode_sarana'.($sarana ? ','.$sarana->id : '')],
            'nama_sarana' => ['required', 'string', 'max:150'],
            'id_kategori' => ['required', 'exists:kategori_saranas,id'],
            'id_ruangan' => ['required', 'exists:ruangans,id'],
            'kondisi' => ['required', 'in:baik,rusak_ringan,rusak_berat'],
            'status_perbaikan' => ['required', 'in:normal,dalam_perbaikan'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);
    }
}
