@extends('layouts.app')

@section('title', 'My Applications - Loker Oku Timur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
        <p class="text-gray-600 mt-2">Track the status of your job applications</p>
    </div>

    @if($applications->count() > 0)
        <div class="space-y-6">
            @foreach($applications as $application)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $application->job->title }}</h3>
                            <p class="text-gray-600">{{ $application->job->company }}</p>
                            <p class="text-sm text-gray-500">{{ $application->job->location }}</p>
                            <p class="text-sm text-gray-500 mt-2">Applied on {{ $application->applied_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mt-4 md:mt-0 md:ml-6">
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                            
                            @if($application->notes)
                                <div class="mt-2 text-sm text-gray-600">
                                    <strong>Note:</strong> {{ $application->notes }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-4 flex space-x-4">
                        <a href="{{ route('jobs.show', $application->job) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            View Job Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
            <p class="mt-1 text-sm text-gray-500">You haven't applied for any jobs yet.</p>
            <div class="mt-6">
                <a href="{{ route('jobs.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    Browse Jobs
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
