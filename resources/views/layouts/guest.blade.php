<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .floating-blob {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                animation: float 6s ease-in-out infinite;
            }
            .floating-blob-2 {
                border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%;
                animation: float 8s ease-in-out infinite reverse;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }
            .gradient-text {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="floating-blob absolute top-1/4 left-1/4 w-64 h-64 bg-gradient-to-r from-pink-400 to-purple-500 opacity-20"></div>
                <div class="floating-blob-2 absolute top-3/4 right-1/4 w-80 h-80 bg-gradient-to-r from-blue-400 to-indigo-500 opacity-20"></div>
                <div class="floating-blob absolute bottom-1/4 left-1/2 w-72 h-72 bg-gradient-to-r from-purple-400 to-pink-500 opacity-15" style="animation-delay: -3s;"></div>
                
                <!-- Sparkle Effects -->
                <div class="absolute top-20 left-20 w-2 h-2 bg-white rounded-full animate-ping"></div>
                <div class="absolute top-40 right-40 w-1 h-1 bg-yellow-300 rounded-full animate-pulse"></div>
                <div class="absolute bottom-40 left-40 w-1.5 h-1.5 bg-pink-300 rounded-full animate-ping" style="animation-delay: -1s;"></div>
                <div class="absolute top-1/2 right-20 w-1 h-1 bg-blue-300 rounded-full animate-pulse" style="animation-delay: -2s;"></div>
            </div>

            <!-- Logo Section -->
            <div class="relative z-10 mb-8">
                <a href="/" class="block text-center group">
                    <div class="relative inline-block">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl flex items-center justify-center shadow-2xl group-hover:shadow-purple-500/50 transition-all duration-300 group-hover:scale-110 mb-4">
                            <span class="text-white text-4xl">🚀</span>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs">✨</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h1 class="text-4xl font-black gradient-text mb-2">JobVibe</h1>
                        <p class="text-white/80 text-sm font-medium">Where careers meet opportunities ✨</p>
                    </div>
                </a>
            </div>

            <!-- Auth Form Container -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/10 backdrop-blur-2xl border border-white/20 shadow-2xl overflow-hidden sm:rounded-3xl relative z-10">
                <!-- Glass effect overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-white/5 rounded-3xl"></div>
                
                <!-- Content -->
                <div class="relative z-10">
                    {{ $slot }}
                </div>
                
                <!-- Decorative elements -->
                <div class="absolute top-4 right-4 w-12 h-12 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-2xl rotate-12"></div>
                <div class="absolute bottom-4 left-4 w-8 h-8 bg-gradient-to-br from-blue-400/30 to-indigo-400/30 rounded-xl -rotate-12"></div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center relative z-10">
                <p class="text-white/60 text-sm">
                    © 2025 JobVibe Oku Timur. Made with 💜 for the community.
                </p>
            </div>
        </div>
    </body>
</html>
