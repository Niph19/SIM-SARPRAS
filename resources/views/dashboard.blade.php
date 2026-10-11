<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Dashboard</h2></x-slot>
    <div class="mx-auto max-w-7xl space-y-4 p-6">
        <div class="grid gap-4 md:grid-cols-3">
            <section class="rounded bg-white p-5 shadow"><h3>Total Sarana</h3><p class="mt-2 text-3xl font-semibold">{{ $totalSarana }}</p></section>
            <section class="rounded bg-white p-5 shadow"><h3>Sarana Bermasalah</h3><p class="mt-2 text-3xl font-semibold">{{ $saranaBermasalah }}</p></section>
            <section class="rounded bg-white p-5 shadow"><h3>Sarana Dalam Perbaikan</h3><p class="mt-2 text-3xl font-semibold">{{ $saranaDalamPerbaikan }}</p></section>
        </div>
        <a class="text-blue-700 underline" href="{{ route('laporan.index') }}">Lihat laporan kerusakan</a>
    </div>
</x-app-layout>
