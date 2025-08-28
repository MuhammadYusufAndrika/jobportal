@extends('layouts.app')

@section('title', 'Lowongan Kerja - Loker Oku Timur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('jobs.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pekerjaan</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Masukkan kata kunci..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <select name="location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Lokasi</option>
                        @foreach(['Martapura', 'Belitang', 'Belitang Hilir', 'Belitang Hulu', 'Belitang Jaya', 'Cit', 'Pedamaran', 'Semendawai Suku III', 'Semendawai Timur', 'Sirah Pulau Padang', 'Sosok'] as $location)
                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                {{ $location }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Perusahaan</label>
                    <select name="company" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Perusahaan</option>
                        @foreach($companies as $company)
                            <option value="{{ $company }}" {{ request('company') == $company ? 'selected' : '' }}>
                                {{ $company }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Jobs Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jobs as $job)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 line-clamp-2">{{ $job->title }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Aktif
                    </span>
                </div>
                
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
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        Deadline: {{ $job->deadline->format('d M Y') }}
                    </div>
                </div>

                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($job->description, 120) }}</p>

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">
                        {{ $job->applications_count }} pelamar
                    </span>
                    <a href="{{ route('jobs.show', $job) }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-sm">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2h8zM8 14v.01M12 14v.01M16 14v.01"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada lowongan kerja</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada lowongan kerja yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($jobs->hasPages())
        <div class="mt-8">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
