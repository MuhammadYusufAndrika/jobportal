@extends('layouts.app')

@section('title', 'Application Details - Company Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="{{ route('company.applications') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Applications
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Application Details</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Application Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Applicant Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Applied Date</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->applied_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Custom Form Data -->
                    @if($application->form_data)
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Application Form Data</h3>
                            <div class="space-y-4">
                                @foreach($application->form_data as $key => $value)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 capitalize">
                                            {{ str_replace('_', ' ', $key) }}
                                        </label>
                                        @if(is_string($value) && str_starts_with($value, 'applications/'))
                                            <!-- File field -->
                                            <div class="mt-1">
                                                <a href="{{ asset('storage/' . $value) }}" target="_blank" 
                                                   class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Download File
                                                </a>
                                            </div>
                                        @else
                                            <p class="mt-1 text-sm text-gray-900">{{ $value ?: 'N/A' }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Job Details & Actions -->
        <div class="lg:col-span-1">
            <!-- Job Information -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Job Information</h2>
                </div>
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900">{{ $application->job->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $application->job->company }}</p>
                    <p class="text-sm text-gray-600">{{ $application->job->location }}</p>
                    <div class="mt-4">
                        <a href="{{ route('jobs.show', $application->job) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            View Job Details
                        </a>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Update Application Status</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('company.application.update-status', $application) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add any notes about this application...">{{ $application->notes }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
