<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">{{ $staff->exists ? 'Ubah' : 'Tambah' }} akun {{ $roleTitle }}</h2></x-slot>
    <main class="mx-auto max-w-2xl p-6"><form method="POST" action="{{ $staff->exists ? route($routePrefix.'.update', $staff) : route($routePrefix.'.store') }}" class="space-y-4 rounded bg-white p-6 shadow">
        @csrf @if ($staff->exists) @method('PUT') @endif
        <div><label for="nama" class="block">Nama</label><input id="nama" name="nama" value="{{ old('nama', $staff->nama) }}" required maxlength="100" class="mt-1 w-full rounded border-gray-300">@error('nama')<p class="text-red-700">{{ $message }}</p>@enderror</div>
        <div><label for="email" class="block">Email</label><input id="email" name="email" type="email" value="{{ old('email', $staff->email) }}" required maxlength="100" class="mt-1 w-full rounded border-gray-300">@error('email')<p class="text-red-700">{{ $message }}</p>@enderror</div>
        <div><label for="password" class="block">Password {{ $staff->exists ? '(kosongkan jika tidak diubah)' : '' }}</label><input id="password" name="password" type="password" @required(! $staff->exists) autocomplete="new-password" class="mt-1 w-full rounded border-gray-300">@error('password')<p class="text-red-700">{{ $message }}</p>@enderror</div>
        <div><label for="password_confirmation" class="block">Konfirmasi password</label><input id="password_confirmation" name="password_confirmation" type="password" @required(! $staff->exists) autocomplete="new-password" class="mt-1 w-full rounded border-gray-300"></div>
        <div class="flex gap-3"><button class="rounded bg-blue-700 px-4 py-2 text-white">Simpan</button><a href="{{ route($routePrefix.'.index') }}" class="rounded border px-4 py-2">Batal</a></div>
    </form></main>
</x-app-layout>
