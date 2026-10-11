<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use App\Models\LaporanSarana;
use App\Models\Ruangan;
use App\Models\Sarana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        if ($request->user()->role === 'murid') {
            return view('laporan.create', [
                'rooms' => Ruangan::orderBy('nama_ruangan')->get(),
                'facilities' => Sarana::with('ruangan')->orderBy('nama_sarana')->get(),
            ]);
        }

        return $this->staffIndex($request);
    }

    public function history(Request $request): View
    {
        $reports = LaporanSarana::with(['sarana', 'ruangan'])
            ->where('id_murid', $request->user()->id)
            ->latest('tanggal_laporan')
            ->paginate(10)
            ->withQueryString();

        return view('laporan.history', compact('reports'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_ruangan' => ['required', 'exists:ruangans,id'],
            'id_sarana' => [
                'required',
                Rule::exists('saranas', 'id')->where(fn ($query) => $query->where('id_ruangan', $request->input('id_ruangan'))),
            ],
            'jenis_kerusakan' => ['required', 'string', 'max:100'],
            'deskripsi_kerusakan' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('laporan', 'public');
        }

        $data['id_murid'] = $request->user()->id;

        LaporanSarana::create($data);

        return to_route('laporan.index')->with('success', 'Laporan kerusakan berhasil dikirim.');
    }

    public function updateStatus(Request $request, LaporanSarana $laporan): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'dalam_perbaikan', 'selesai', 'ditolak'])],
        ]);

        $allowedTransitions = [
            'pending' => ['dalam_perbaikan', 'ditolak'],
            'dalam_perbaikan' => ['selesai', 'ditolak'],
            'selesai' => [],
            'ditolak' => [],
        ];

        if (! in_array($data['status'], $allowedTransitions[$laporan->status], true)) {
            throw ValidationException::withMessages([
                'status' => 'Perubahan status laporan tidak sesuai alur yang diizinkan.',
            ]);
        }

        DB::transaction(function () use ($laporan, $data) {
            $laporan->update(['status' => $data['status']]);

            if ($data['status'] === 'dalam_perbaikan') {
                $laporan->sarana()->update(['status_perbaikan' => 'dalam_perbaikan']);
            } elseif (! $laporan->sarana->laporan()->where('status', 'dalam_perbaikan')->exists()) {
                $laporan->sarana()->update(['status_perbaikan' => 'normal']);
            }
        });

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    private function staffIndex(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['pending', 'dalam_perbaikan', 'selesai', 'ditolak'])],
            'id_kategori' => ['nullable', 'integer', 'exists:kategori_saranas,id'],
        ]);
        $search = trim($filters['search'] ?? '');
        $categoryId = $filters['id_kategori'] ?? null;
        $reports = LaporanSarana::with(['murid', 'sarana.kategori', 'ruangan'])
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('jenis_kerusakan', 'like', "%{$search}%")
                    ->orWhere('deskripsi_kerusakan', 'like', "%{$search}%")
                    ->orWhereHas('sarana', fn ($query) => $query->where('nama_sarana', 'like', "%{$search}%")
                        ->orWhere('kode_sarana', 'like', "%{$search}%"))
                    ->orWhereHas('murid', fn ($query) => $query->where('nama', 'like', "%{$search}%"));
            }))
            ->when(isset($filters['status']), fn ($query) => $query->where('status', $filters['status']))
            ->when($categoryId, fn ($query) => $query->whereHas('sarana', fn ($query) => $query->where('id_kategori', $categoryId)))
            ->latest('tanggal_laporan')
            ->paginate(10)
            ->withQueryString();

        return view('laporan.staff-index', [
            'reports' => $reports,
            'search' => $search,
            'status' => $filters['status'] ?? '',
            'categoryId' => $categoryId,
            'categories' => KategoriSarana::orderBy('nama_kategori')->get(),
        ]);
    }
}
