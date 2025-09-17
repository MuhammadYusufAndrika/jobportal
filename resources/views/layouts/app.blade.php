<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .glassmorphism {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .animated-blob {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                animation: blob 7s ease-in-out infinite;
            }
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-violet-50 via-purple-50 to-indigo-100 relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="animated-blob absolute top-0 left-0 w-72 h-72 bg-gradient-to-r from-purple-400 to-pink-400 opacity-20 -translate-x-1/2 -translate-y-1/2"></div>
                <div class="animated-blob absolute top-1/2 right-0 w-96 h-96 bg-gradient-to-r from-blue-400 to-indigo-400 opacity-20 translate-x-1/2" style="animation-delay: -2s;"></div>
                <div class="animated-blob absolute bottom-0 left-1/3 w-80 h-80 bg-gradient-to-r from-pink-400 to-purple-400 opacity-20 translate-y-1/2" style="animation-delay: -4s;"></div>
            </div>

            <!-- Main Navigation -->
            <div class="relative z-10">
                @include('layouts.navigation')
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 backdrop-blur-lg border-b border-white/20 shadow-sm relative z-10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative z-10">
                @yield('content')
            </main>
        </div>
    </body>
</html>
