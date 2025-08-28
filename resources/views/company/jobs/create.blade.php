@extends('layouts.app')

@section('title', 'Create Job - Company Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="{{ route('company.jobs.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Jobs
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Create New Job</h1>
        <p class="text-gray-600 mt-2">Post a new job opportunity</p>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('company.jobs.store') }}" method="POST">
            @csrf
            
            <!-- Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
                        <input type="text" name="title" id="title" required 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('title') }}">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                        <input type="text" name="company" id="company" required 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('company') }}">
                        @error('company')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                        <select name="location" id="location" required 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ old('location') == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="employment_type" class="block text-sm font-medium text-gray-700 mb-2">Employment Type *</label>
                        <select name="employment_type" id="employment_type" required 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Type</option>
                            <option value="full-time" {{ old('employment_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part-time" {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                            <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        @error('employment_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="salary" class="block text-sm font-medium text-gray-700 mb-2">Salary Range</label>
                        <input type="text" name="salary" id="salary" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., Rp 5,000,000 - 8,000,000"
                               value="{{ old('salary') }}">
                        @error('salary')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Application Deadline *</label>
                        <input type="date" name="deadline" id="deadline" required 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('deadline')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Job Description -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Job Details</h2>
                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Job Description *</label>
                        <textarea name="description" id="description" rows="6" required 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Describe the job responsibilities, duties, and what the role entails...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">Requirements *</label>
                        <textarea name="requirements" id="requirements" rows="6" required 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="List the qualifications, skills, and experience required...">{{ old('requirements') }}</textarea>
                        @error('requirements')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Application Form Builder -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Custom Application Form</h2>
                <p class="text-gray-600 mb-4">Create custom fields for your application form (optional)</p>
                
                <div id="form-fields">
                    <!-- Dynamic form fields will be added here -->
                </div>

                <button type="button" id="add-field" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
                    Add Form Field
                </button>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('company.jobs.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    Create Job
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let fieldCount = 0;

document.getElementById('add-field').addEventListener('click', function() {
    const formFields = document.getElementById('form-fields');
    const fieldDiv = document.createElement('div');
    fieldDiv.className = 'border border-gray-300 rounded-md p-4 mb-4';
    fieldDiv.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Field Label</label>
                <input type="text" name="application_form[${fieldCount}][label]" required 
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Field Type</label>
                <select name="application_form[${fieldCount}][type]" required 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onchange="toggleOptions(this, ${fieldCount})">
                    <option value="text">Text</option>
                    <option value="email">Email</option>
                    <option value="number">Number</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="file">File</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Required</label>
                <label class="flex items-center">
                    <input type="checkbox" name="application_form[${fieldCount}][required]" value="1" 
                           class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    Required Field
                </label>
            </div>
            <div>
                <button type="button" onclick="removeField(this)" 
                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition duration-200 mt-6">
                    Remove
                </button>
            </div>
        </div>
        <div id="options-${fieldCount}" class="hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">Options (comma-separated)</label>
            <input type="text" name="application_form[${fieldCount}][options]" 
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Option 1, Option 2, Option 3">
        </div>
    `;
    formFields.appendChild(fieldDiv);
    fieldCount++;
});

function toggleOptions(selectElement, index) {
    const optionsDiv = document.getElementById(`options-${index}`);
    if (selectElement.value === 'select') {
        optionsDiv.classList.remove('hidden');
    } else {
        optionsDiv.classList.add('hidden');
    }
}

function removeField(button) {
    button.closest('.border').remove();
}
</script>
@endsection
