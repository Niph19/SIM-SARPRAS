<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\KategoriSarana;
use App\Models\Sarana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BeritaAcaraController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'id_kategori' => ['nullable', 'integer', 'exists:kategori_saranas,id'],
        ]);
        $search = trim($filters['search'] ?? '');
        $categoryId = $filters['id_kategori'] ?? null;
        $records = BeritaAcara::with(['sarana.kategori', 'pembuat'])
            ->when($request->user()->role === 'guru', fn ($query) => $query->where('id_user_pembuat', $request->user()->id))
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('no_berita_acara', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('sarana', fn ($query) => $query->where('nama_sarana', 'like', "%{$search}%"));
            }))
            ->when($categoryId, fn ($query) => $query->whereHas('sarana', fn ($query) => $query->where('id_kategori', $categoryId)))
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('berita-acara.index', [
            'records' => $records,
            'search' => $search,
            'categoryId' => $categoryId,
            'categories' => KategoriSarana::orderBy('nama_kategori')->get(),
        ]);
    }

    public function create(): View
    {
        return view('berita-acara.form', [
            'record' => new BeritaAcara,
            'facilities' => Sarana::orderBy('nama_sarana')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $record = BeritaAcara::create([
            ...$this->validatedData($request),
            'id_user_pembuat' => $request->user()->id,
        ]);

        return to_route('berita-acara.show', $record)->with('success', 'Berita acara berhasil dibuat.');
    }

    public function show(BeritaAcara $berita_acara, Request $request): View
    {
        $this->authorizeOwner($berita_acara, $request);

        return view('berita-acara.show', ['record' => $berita_acara->load(['sarana.kategori', 'sarana.ruangan', 'pembuat'])]);
    }

    public function print(BeritaAcara $berita_acara, Request $request): View
    {
        $this->authorizeOwner($berita_acara, $request);

        return view('berita-acara.print', ['record' => $berita_acara->load(['sarana.kategori', 'sarana.ruangan', 'pembuat'])]);
    }

    public function edit(BeritaAcara $berita_acara): View
    {
        return view('berita-acara.form', [
            'record' => $berita_acara,
            'facilities' => Sarana::orderBy('nama_sarana')->get(),
        ]);
    }

    public function update(Request $request, BeritaAcara $berita_acara): RedirectResponse
    {
        $berita_acara->update($this->validatedData($request, $berita_acara));

        return to_route('berita-acara.show', $berita_acara)->with('success', 'Berita acara berhasil diperbarui.');
    }

    public function destroy(BeritaAcara $berita_acara): RedirectResponse
    {
        $berita_acara->delete();

        return to_route('berita-acara.index')->with('success', 'Berita acara berhasil dihapus.');
    }

    private function validatedData(Request $request, ?BeritaAcara $record = null): array
    {
        return $request->validate([
            'no_berita_acara' => ['required', 'string', 'max:100', Rule::unique('berita_acaras', 'no_berita_acara')->ignore($record?->id)],
            'id_sarana' => ['required', 'exists:saranas,id'],
            'jenis_tindakan' => ['required', Rule::in(['perbaikan', 'pemeliharaan', 'penghapusan'])],
            'keterangan' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
        ]);
    }

    private function authorizeOwner(BeritaAcara $record, Request $request): void
    {
        abort_if($request->user()->role === 'guru' && $record->id_user_pembuat !== $request->user()->id, 403);
    }
}
