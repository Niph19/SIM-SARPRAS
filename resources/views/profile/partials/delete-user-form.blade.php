<section class="space-y-5">
    <header>
        <h2 class="text-base font-semibold text-red-800">
            Hapus Akun
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Setelah akun dihapus, semua data akan hilang secara permanen. Pastikan kamu sudah menyimpan data yang diperlukan.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Hapus Akun Saya</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-base font-semibold text-gray-900">
                Yakin ingin menghapus akun?
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Semua data dan informasi akun akan dihapus secara permanen. Masukkan password untuk konfirmasi penghapusan akun.
            </p>

            <div class="mt-5">
                <x-input-label for="password" value="Password" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Masukkan password"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Hapus Akun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
