@extends('layouts.app')

@section('title', 'Loker Oku Timur - Portal Lowongan Kerja')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Temukan Karir Terbaik di 
                <div class="text-yellow-300">Oku Timur</div>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-8">
                Portal resmi lowongan kerja Kabupaten Ogan Komering Ulu Timur. 
                Menghubungkan talenta lokal dengan peluang kerja terbaik.
            </p>
            
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <form method="GET" action="{{ route('jobs.index') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               placeholder="Cari pekerjaan impian Anda..." 
                               class="w-full px-6 py-4 text-gray-900 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300">
                    </div>
                    <div class="md:w-auto">
                        <button type="submit" 
                                class="w-full md:w-auto px-8 py-4 bg-yellow-400 text-gray-900 font-semibold rounded-lg hover:bg-yellow-300 transition duration-200">
                            Cari Kerja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-blue-600 mb-2">{{ $totalJobs }}</div>
                <div class="text-gray-600">Lowongan Aktif</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-blue-600 mb-2">{{ $totalCompanies }}</div>
                <div class="text-gray-600">Perusahaan</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-blue-600 mb-2">{{ $totalApplications }}</div>
                <div class="text-gray-600">Lamaran Terkirim</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Jobs Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Lowongan Terbaru</h2>
            <p class="text-xl text-gray-600">Temukan peluang karir terbaik di Oku Timur</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredJobs as $job)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Baru
                        </span>
                        <span class="text-sm text-gray-500">{{ $job->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">{{ $job->title }}</h3>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-6a1 1 0 00-1-1H9a1 1 0 00-1 1v6a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $job->company }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $job->location }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-1.092a4.535 4.535 0 001.676-.662C13.398 12.766 14 11.991 14 11c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 8.092V6.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V4z" clip-rule="evenodd"></path>
                            </svg>
                            Rp {{ number_format($job->salary, 0, ',', '.') }}
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($job->description, 100) }}</p>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            Deadline: {{ $job->deadline->format('d M Y') }}
                        </span>
                        <a href="{{ route('jobs.show', $job) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 text-sm font-medium">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h8zM8 14v.01M12 14v.01M16 14v.01"></path>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada lowongan kerja</h3>
                    <p class="text-gray-500">Lowongan kerja terbaru akan ditampilkan di sini.</p>
                </div>
            @endforelse
        </div>

        @if($featuredJobs->count() > 0)
            <div class="text-center mt-12">
                <a href="{{ route('jobs.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                    Lihat Semua Lowongan
                    <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Locations Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Lokasi Kerja Tersedia</h2>
            <p class="text-xl text-gray-600">Peluang karir tersebar di seluruh Kabupaten Oku Timur</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach(['Martapura', 'Belitang', 'Belitang Hilir', 'Belitang Hulu', 'Belitang Jaya', 'Cit', 'Pedamaran', 'Semendawai Suku III', 'Semendawai Timur', 'Sirah Pulau Padang', 'Sosok'] as $location)
                <a href="{{ route('jobs.index', ['location' => $location]) }}" 
                   class="bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-300 rounded-lg p-4 text-center transition duration-200 group">
                    <div class="text-lg font-medium text-gray-900 group-hover:text-blue-600">{{ $location }}</div>
                    <div class="text-sm text-gray-500 mt-1">
                        {{ $jobsByLocation[$location] ?? 0 }} lowongan
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-blue-600">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Siap Memulai Karir di Oku Timur?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Bergabunglah dengan ribuan pencari kerja lainnya dan temukan peluang karir yang tepat untuk Anda.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @guest
                <a href="{{ route('register') }}" 
                   class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                    Daftar Sekarang
                </a>
                <a href="{{ route('jobs.index') }}" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-200">
                    Jelajahi Lowongan
                </a>
            @else
                <a href="{{ route('jobs.index') }}" 
                   class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                    Jelajahi Lowongan
                </a>
            @endguest
        </div>
    </div>
</section>
@endsection
</html>
