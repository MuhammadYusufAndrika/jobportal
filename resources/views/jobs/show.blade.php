@extends('layouts.app')

@section('title', $job->title . ' - Loker Oku Timur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                Kembali ke Daftar Lowongan
            </a>
        </div>

        <!-- Job Header -->
        <div class="border-b border-gray-200 pb-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h1>
                    <div class="flex flex-wrap gap-4 text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-6a1 1 0 00-1-1H9a1 1 0 00-1 1v6a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $job->company }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $job->location }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-1.092a4.535 4.535 0 001.676-.662C13.398 12.766 14 11.991 14 11c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 8.092V6.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V4z" clip-rule="evenodd"></path>
                            </svg>
                            Rp {{ number_format($job->salary, 0, ',', '.') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            Deadline: {{ $job->deadline->format('d M Y') }}
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        {{ $job->isActive() ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                    <p class="text-sm text-gray-500 mt-1">{{ $job->applications->count() }} pelamar</p>
                </div>
            </div>
        </div>

        <!-- Job Description -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Pekerjaan</h2>
            <div class="prose prose-blue max-w-none">
                {!! nl2br(e($job->description)) !!}
            </div>
        </div>

        <!-- Application Form -->
        @auth
            @if($job->isActive())
                @if($hasApplied)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-medium text-yellow-800">Anda sudah melamar pekerjaan ini</h3>
                                <p class="text-yellow-700">Lamaran Anda telah dikirim pada {{ $userApplication->applied_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @elseif(auth()->user()->hasRole('user'))
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Lamar Pekerjaan Ini</h2>
                        
                        @if($job->application_form && count($job->application_form) > 0)
                            <form method="POST" action="{{ route('jobs.apply', $job) }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                
                                @foreach($job->application_form as $field)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ $field['label'] }}
                                            @if($field['required'] ?? false)
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>
                                        
                                        @switch($field['type'])
                                            @case('text')
                                            @case('email')
                                                <input type="{{ $field['type'] }}" 
                                                       name="form_data[{{ $loop->index }}]" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                @break
                                            
                                            @case('number')
                                                <input type="number" 
                                                       name="form_data[{{ $loop->index }}]" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                @break
                                            
                                            @case('textarea')
                                                <textarea name="form_data[{{ $loop->index }}]" 
                                                          rows="4" 
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                          {{ ($field['required'] ?? false) ? 'required' : '' }}></textarea>
                                                @break
                                            
                                            @case('file')
                                                <input type="file" 
                                                       name="form_data[{{ $loop->index }}]" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                @break
                                            
                                            @case('select')
                                                <select name="form_data[{{ $loop->index }}]" 
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                    <option value="">Pilih...</option>
                                                    @if(isset($field['options']))
                                                        @foreach(explode(',', $field['options']) as $option)
                                                            <option value="{{ trim($option) }}">{{ trim($option) }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @break
                                            
                                            @case('radio')
                                                @if(isset($field['options']))
                                                    <div class="space-y-2">
                                                        @foreach(explode(',', $field['options']) as $option)
                                                            <label class="flex items-center">
                                                                <input type="radio" 
                                                                       name="form_data[{{ $loop->parent->index }}]" 
                                                                       value="{{ trim($option) }}" 
                                                                       class="mr-2"
                                                                       {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                                                {{ trim($option) }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @break
                                            
                                            @case('checkbox')
                                                @if(isset($field['options']))
                                                    <div class="space-y-2">
                                                        @foreach(explode(',', $field['options']) as $option)
                                                            <label class="flex items-center">
                                                                <input type="checkbox" 
                                                                       name="form_data[{{ $loop->parent->index }}][]" 
                                                                       value="{{ trim($option) }}" 
                                                                       class="mr-2">
                                                                {{ trim($option) }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @break
                                        @endswitch
                                    </div>
                                @endforeach
                                
                                <div class="pt-4">
                                    <button type="submit" 
                                            class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-200 font-medium">
                                        Kirim Lamaran
                                    </button>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ route('jobs.apply', $job) }}">
                                @csrf
                                <p class="text-gray-600 mb-4">Tidak ada form khusus untuk pekerjaan ini. Klik tombol di bawah untuk melamar.</p>
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-200 font-medium">
                                    Lamar Sekarang
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="text-gray-600">Hanya pengguna dengan role "user" yang dapat melamar pekerjaan.</p>
                    </div>
                @endif
            @else
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-red-800">Lowongan Tidak Aktif</h3>
                            <p class="text-red-700">Maaf, lowongan ini sudah tidak aktif atau deadline sudah terlewat.</p>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-blue-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-medium text-blue-800">Login Diperlukan</h3>
                        <p class="text-blue-700">Silakan <a href="{{ route('login') }}" class="underline">login</a> terlebih dahulu untuk melamar pekerjaan ini.</p>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</div>
@endsection
