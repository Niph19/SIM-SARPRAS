<?php

namespace App\Http\Controllers;

use App\Models\LaporanSarana;
use App\Models\Sarana;
use Illuminate\View\View;

class DashboardAdminController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'totalSarana' => Sarana::count(),
            'saranaBermasalah' => LaporanSarana::whereIn('status', ['pending', 'dalam_perbaikan'])->count(),
            'saranaDalamPerbaikan' => Sarana::where('status_perbaikan', 'dalam_perbaikan')->count(),
        ]);
    }
}
