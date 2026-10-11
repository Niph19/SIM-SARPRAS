<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

abstract class StaffController extends Controller
{
    protected string $role;

    protected string $routePrefix;

    protected string $title;

    public function index(Request $request): View
    {
        $filters = $request->validate(['search' => ['nullable', 'string', 'max:100']]);
        $search = trim($filters['search'] ?? '');
        $users = User::where('role', $this->role)
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', [
            'users' => $users,
            'search' => $search,
            'roleTitle' => $this->title,
            'routePrefix' => $this->routePrefix,
        ]);
    }

    public function create(): View
    {
        return view('users.form', [
            'staff' => new User,
            'roleTitle' => $this->title,
            'routePrefix' => $this->routePrefix,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        $data['role'] = $this->role;

        User::create($data);

        return to_route($this->routePrefix.'.index')->with('success', $this->title.' berhasil ditambahkan.');
    }

    public function edit(User $staff): View
    {
        abort_unless($staff->role === $this->role, 404);

        return view('users.form', [
            'staff' => $staff,
            'roleTitle' => $this->title,
            'routePrefix' => $this->routePrefix,
        ]);
    }

    public function update(Request $request, User $staff): RedirectResponse
    {
        abort_unless($staff->role === $this->role, 404);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email,'.$staff->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if (filled($data['password'] ?? null)) {
            $staff->password = Hash::make($data['password']);
        }

        $staff->fill([
            'nama' => $data['nama'],
            'email' => $data['email'],
        ])->save();

        return to_route($this->routePrefix.'.index')->with('success', $this->title.' berhasil diperbarui.');
    }

    public function destroy(User $staff): RedirectResponse
    {
        abort_unless($staff->role === $this->role, 404);

        if ($staff->is(auth()->user()) || $staff->beritaAcara()->exists()) {
            return back()->withErrors([
                'staff' => 'Akun ini tidak dapat dihapus karena merupakan akun aktif atau masih memiliki berita acara.',
            ]);
        }

        $staff->delete();

        return to_route($this->routePrefix.'.index')->with('success', $this->title.' berhasil dihapus.');
    }
}
