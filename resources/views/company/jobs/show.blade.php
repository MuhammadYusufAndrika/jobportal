@extends('layouts.app')

@section('title', $job->title . ' - Company Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="{{ route('company.jobs.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Jobs
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $job->company }} • {{ $job->location }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('company.jobs.edit', $job) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Edit Job
                </a>
                <a href="{{ route('jobs.show', $job) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                    View Public Page
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Job Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Job Details</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Employment Type</label>
                            <p class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('-', ' ', $job->employment_type) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Salary</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $job->salary ?: 'Not specified' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Application Deadline</label>
                            <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            @if($job->is_active && $job->deadline >= now()->toDateString())
                                <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Job Description</h3>
                        <div class="prose max-w-none">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Requirements</h3>
                        <div class="prose max-w-none">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics & Applications -->
        <div class="lg:col-span-1">
            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Statistics</h2>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $job->applications->count() }}</div>
                        <div class="text-sm text-gray-600">Total Applications</div>
                    </div>
                    
                    <div class="mt-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Pending</span>
                            <span class="text-sm font-medium">{{ $job->applications->where('status', 'pending')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Accepted</span>
                            <span class="text-sm font-medium text-green-600">{{ $job->applications->where('status', 'accepted')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Rejected</span>
                            <span class="text-sm font-medium text-red-600">{{ $job->applications->where('status', 'rejected')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            @if($job->applications->count() > 0)
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-semibold">Recent Applications</h2>
                            <a href="{{ route('company.applications') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($job->applications->take(5) as $application)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <h3 class="font-semibold text-gray-900">{{ $application->user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $application->applied_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('company.application.show', $application) }}" class="text-blue-600 hover:text-blue-800 text-xs">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
