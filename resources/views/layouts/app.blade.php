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
    <body class="font-mono antialiased bg-gray-50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                            <div>
                                {{ $header }}
                            </div>
                            <div class="hidden sm:block">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span class="inline-flex items-center">
                                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                        Sistem Aktif
                                    </span>
                                    <span>{{ now()->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative">
                <!-- Flash Messages -->
                @include('shared.flash')

                {{ $slot }}
            </main>
        </div>

        <!-- Background Pattern -->
        <div class="fixed inset-0 pointer-events-none opacity-30 z-0">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 85% 15%, #db277708 0%, transparent 50%), radial-gradient(circle at 15% 85%, #2563eb08 0%, transparent 50%)"></div>
        </div>
    </body>
</html>
