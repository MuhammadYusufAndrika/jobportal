@extends('layouts.app')

@section('title', 'Company Dashboard - Loker Oku Timur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Company Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H8a2 2 0 00-2-2V6m8 0h2a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalJobs }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Jobs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $activeJobs }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Applications</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalApplications }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Applications</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pendingApplications }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('company.jobs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Create New Job
                </a>
                <a href="{{ route('company.applications') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                    View All Applications
                </a>
                <a href="{{ route('company.jobs.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-200">
                    Manage Jobs
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- My Jobs -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold">Recent Jobs</h2>
            </div>
            <div class="p-6">
                @if($jobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($jobs->take(5) as $job)
                            <div class="border-l-4 border-blue-500 pl-4">
                                <h3 class="font-semibold text-gray-900">{{ $job->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $job->location }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-gray-500">{{ $job->applications_count }} applications</span>
                                    <span class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($jobs->count() > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('company.jobs.index') }}" class="text-blue-600 hover:text-blue-800">View all jobs</a>
                        </div>
                    @endif
                @else
                    <p class="text-gray-500">No jobs posted yet.</p>
                @endif
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold">Recent Applications</h2>
            </div>
            <div class="p-6">
                @if($applications->count() > 0)
                    <div class="space-y-4">
                        @foreach($applications->take(5) as $application)
                            <div class="border-l-4 border-green-500 pl-4">
                                <h3 class="font-semibold text-gray-900">{{ $application->user->name }}</h3>
                                <p class="text-sm text-gray-600">Applied for: {{ $application->job->title }}</p>
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
                            </div>
                        @endforeach
                    </div>
                    @if($applications->count() > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('company.applications') }}" class="text-blue-600 hover:text-blue-800">View all applications</a>
                        </div>
                    @endif
                @else
                    <p class="text-gray-500">No applications received yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
