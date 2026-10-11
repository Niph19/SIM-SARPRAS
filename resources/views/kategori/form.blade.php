<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">{{ $category->exists ? 'Ubah' : 'Tambah' }} kategori</h2></x-slot>
    <main class="mx-auto max-w-2xl p-6">
        <form method="POST" action="{{ $category->exists ? route('kategori.update', $category) : route('kategori.store') }}" class="space-y-4 rounded bg-white p-6 shadow">
            @csrf @if ($category->exists) @method('PUT') @endif
            <div><label for="nama_kategori" class="block">Nama kategori</label><input id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" required maxlength="100" class="mt-1 w-full rounded border-gray-300">@error('nama_kategori')<p class="text-red-700">{{ $message }}</p>@enderror</div>
            <div><label for="deskripsi" class="block">Deskripsi</label><textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 w-full rounded border-gray-300">{{ old('deskripsi', $category->deskripsi) }}</textarea>@error('deskripsi')<p class="text-red-700">{{ $message }}</p>@enderror</div>
            @if ($errors->has('kategori'))<p class="text-red-700">{{ $errors->first('kategori') }}</p>@endif
            <div class="flex gap-3"><button class="rounded bg-blue-700 px-4 py-2 text-white">Simpan</button><a href="{{ route('kategori.index') }}" class="rounded border px-4 py-2">Batal</a></div>
        </form>
    </main>
</x-app-layout>
