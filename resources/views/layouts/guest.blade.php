<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SatuSarpras') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-mono antialiased bg-gradient-to-br from-primary-50 via-secondary-50 to-white">
        <!-- Background Pattern -->
        <div class="fixed inset-0 opacity-30">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 80%, #db277733 0%, transparent 50%), radial-gradient(circle at 80% 20%, #2563eb33 0%, transparent 50%)"></div>
        </div>

        <div class="relative min-h-screen flex flex-col justify-center items-center px-4 py-12">
            <!-- Logo Section -->
            <div class="mb-8 text-center">
                <a href="/" class="inline-block group">
                    <x-application-logo class="h-24 w-auto transition-transform duration-300 group-hover:scale-105" />
                </a>
                <p class="mt-4 text-sm text-gray-600 font-light tracking-wide">Sistem Informasi Manajemen Sarana Prasarana</p>
            </div>

            <!-- Form Container -->
            <div class="w-full max-w-md">
                <div class="bg-white/80 backdrop-blur-sm shadow-2xl border border-gray-200/50 overflow-hidden rounded-md p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-12 text-center">
                <p class="text-xs text-gray-500 font-light">
                    © {{ date('Y') }} SatuSarpras. Sistem manajemen fasilitas sekolah yang modern.
                </p>
            </div>
        </div>
    </body>
</html>
