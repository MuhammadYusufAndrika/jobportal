@extends('layouts.app')

@section('title', 'JobVibe - Where Dreams Meet Opportunities 🚀')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto text-center">
            <!-- Main Heading -->
            <div class="mb-8">
                <h1 class="text-6xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 mb-6 leading-tight">
                    Find Your
                    <br>
                    <span class="bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 bg-clip-text text-transparent animate-pulse">
                        Dream Job
                    </span>
                </h1>
                <div class="flex items-center justify-center space-x-4 mb-6">
                    <span class="text-3xl">🌟</span>
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-800">
                        in Oku Timur!
                    </h2>
                    <span class="text-3xl">🚀</span>
                </div>
            </div>
            
            <p class="text-xl md:text-2xl text-gray-600 mb-12 leading-relaxed max-w-4xl mx-auto">
                The ultimate job portal that connects amazing talents with incredible opportunities. 
                <br class="hidden md:block">
                Your next adventure starts here! ✨
            </p>
            
            <!-- Search Bar -->
            <div class="max-w-4xl mx-auto mb-12">
                <form method="GET" action="{{ route('jobs.index') }}" class="relative group">
                    <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl p-3 border border-white/30 shadow-2xl group-hover:shadow-3xl transition-all duration-300">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-2xl">🔍</span>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       placeholder="Search for your dream job..." 
                                       class="w-full pl-14 pr-6 py-4 text-lg text-gray-900 bg-transparent border-0 focus:outline-none focus:ring-0 placeholder-gray-500">
                            </div>
                            <div class="md:w-auto">
                                <button type="submit" 
                                        class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-lg font-bold rounded-2xl hover:from-purple-700 hover:to-pink-700 transition-all duration-300 hover:scale-105 shadow-lg flex items-center justify-center">
                                    <span class="mr-2">✨</span>
                                    Find Jobs
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 relative">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="text-center group">
                <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="text-6xl font-black bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-4">
                        {{ $totalJobs }}
                    </div>
                    <div class="text-gray-700 font-semibold text-lg flex items-center justify-center">
                        <span class="mr-2">💼</span>
                        Active Jobs
                    </div>
                </div>
            </div>
            <div class="text-center group">
                <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="text-6xl font-black bg-gradient-to-r from-pink-600 to-orange-600 bg-clip-text text-transparent mb-4">
                        {{ $totalCompanies }}
                    </div>
                    <div class="text-gray-700 font-semibold text-lg flex items-center justify-center">
                        <span class="mr-2">🏢</span>
                        Companies
                    </div>
                </div>
            </div>
            <div class="text-center group">
                <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-8 border border-white/20 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <div class="text-6xl font-black bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent mb-4">
                        {{ $totalApplications }}
                    </div>
                    <div class="text-gray-700 font-semibold text-lg flex items-center justify-center">
                        <span class="mr-2">📧</span>
                        Applications
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Jobs Section -->
<section class="py-20 relative">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-6">
                Hot Jobs 🔥
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover the latest and greatest opportunities in Oku Timur
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @forelse($featuredJobs as $job)
                <div class="group bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 border border-white/20 hover:scale-105">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gradient-to-r from-green-400 to-blue-500 text-white">
                                <span class="mr-1">🆕</span>
                                New
                            </span>
                        </div>
                        <span class="text-sm text-gray-500 bg-white/50 px-3 py-1 rounded-full">{{ $job->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 line-clamp-2 group-hover:text-purple-600 transition-colors duration-300">
                        {{ $job->title }}
                    </h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-gray-600">
                            <span class="text-lg mr-3">🏢</span>
                            <span class="font-medium">{{ $job->company }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <span class="text-lg mr-3">📍</span>
                            <span class="font-medium">{{ $job->location }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <span class="text-lg mr-3">💰</span>
                            <span class="font-bold text-green-600">Rp {{ number_format($job->salary, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-6 line-clamp-3">{{ Str::limit($job->description, 120) }}</p>

                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            ⏰ {{ $job->deadline->format('d M Y') }}
                        </div>
                        <a href="{{ route('jobs.show', $job) }}" 
                           class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-2xl hover:from-purple-700 hover:to-pink-700 transition-all duration-300 text-sm font-bold hover:scale-105 shadow-lg flex items-center">
                            <span class="mr-2">👀</span>
                            View Job
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="text-6xl mb-6">🔍</div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">No Jobs Available Yet</h3>
                    <p class="text-xl text-gray-600">Check back soon for awesome opportunities!</p>
                </div>
            @endforelse
        </div>

        @if($featuredJobs->count() > 0)
            <div class="text-center mt-16">
                <a href="{{ route('jobs.index') }}" 
                   class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-lg font-bold rounded-3xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 hover:scale-105 shadow-xl">
                    <span class="mr-3 text-xl">🚀</span>
                    Explore All Jobs
                    <svg class="ml-3 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Locations Section -->
<section class="py-20 relative">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-green-600 mb-6">
                Explore Locations 🗺️
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Opportunities are everywhere in Oku Timur! Find your perfect workplace location
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            @php
                $emojis = ['🏢', '🌆', '🏭', '🌟', '🎯', '💼', '🚀', '⭐', '🔥', '✨', '💎'];
                $locations = ['Martapura', 'Belitang', 'Belitang Hilir', 'Belitang Hulu', 'Belitang Jaya', 'Cit', 'Pedamaran', 'Semendawai Suku III', 'Semendawai Timur', 'Sirah Pulau Padang', 'Sosok'];
            @endphp
            
            @foreach($locations as $index => $location)
                <a href="{{ route('jobs.index', ['location' => $location]) }}" 
                   class="group bg-white/60 backdrop-blur-xl border border-white/20 rounded-3xl p-6 text-center hover:bg-white/80 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="text-4xl mb-4">
                        {{ $emojis[$index % count($emojis)] }}
                    </div>
                    <div class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300 mb-2">
                        {{ $location }}
                    </div>
                    <div class="text-sm text-gray-600 bg-white/50 rounded-full px-3 py-1 inline-block">
                        {{ $jobsByLocation[$location] ?? 0 }} jobs
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 relative">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 mb-8">
                Ready to Start Your Journey? 
            </h2>
            <div class="text-4xl mb-8">🚀✨🌟</div>
            <p class="text-xl text-gray-600 mb-12 leading-relaxed max-w-3xl mx-auto">
                Join thousands of job seekers who found their dream careers through JobVibe! 
                Your next opportunity is waiting for you.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                @guest
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xl font-bold rounded-3xl hover:from-purple-700 hover:to-pink-700 transition-all duration-300 hover:scale-110 shadow-2xl">
                        <span class="mr-3 text-2xl">🎉</span>
                        Get Started
                    </a>
                    <a href="{{ route('jobs.index') }}" 
                       class="inline-flex items-center px-10 py-5 bg-white/80 backdrop-blur-xl text-gray-900 text-xl font-bold rounded-3xl hover:bg-white transition-all duration-300 hover:scale-110 shadow-2xl border border-white/20">
                        <span class="mr-3 text-2xl">🔍</span>
                        Browse Jobs
                    </a>
                @else
                    <a href="{{ route('jobs.index') }}" 
                       class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-green-500 to-blue-600 text-white text-xl font-bold rounded-3xl hover:from-green-600 hover:to-blue-700 transition-all duration-300 hover:scale-110 shadow-2xl">
                        <span class="mr-3 text-2xl">💼</span>
                        Find Your Dream Job
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

@endsection
