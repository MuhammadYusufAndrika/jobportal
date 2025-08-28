<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::query()
            ->where('is_active', true)
            ->where('deadline', '>=', now()->toDateString())
            ->with('user')
            ->withCount('applications');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('company', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Company filter
        if ($request->filled('company')) {
            $query->where('company', $request->company);
        }

        // Sort by latest first
        $jobs = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get all companies for filter
        $companies = Job::where('is_active', true)
            ->where('deadline', '>=', now()->toDateString())
            ->distinct('company')
            ->pluck('company')
            ->sort();

        return view('jobs.index', compact('jobs', 'companies'));
    }
    public function show(Job $job)
    {
        if (!$job->isActive()) {
            abort(404);
        }

        $hasApplied = false;
        $userApplication = null;

        if (Auth::check()) {
            $userApplication = Application::where('job_id', $job->id)
                ->where('user_id', Auth::id())
                ->first();
            $hasApplied = $userApplication !== null;
        }

        return view('jobs.show', compact('job', 'hasApplied', 'userApplication'));
    }

    public function apply(Request $request, Job $job)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to apply for jobs.');
        }

        if (!$job->isActive()) {
            return back()->with('error', 'This job is no longer available.');
        }

        // Check if user already applied
        $existingApplication = Application::where('job_id', $job->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this job.');
        }

        // Validate the form data based on the job's application form
        $rules = [];
        $formData = [];

        if ($job->application_form) {
            foreach ($job->application_form as $field) {
                $fieldName = 'form_data.' . str_replace(' ', '_', strtolower($field['label']));

                if ($field['required']) {
                    $rules[$fieldName] = 'required';
                } else {
                    $rules[$fieldName] = 'nullable';
                }

                if ($field['type'] === 'email') {
                    $rules[$fieldName] .= '|email';
                } elseif ($field['type'] === 'number') {
                    $rules[$fieldName] .= '|numeric';
                } elseif ($field['type'] === 'file') {
                    $rules[$fieldName] .= '|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'; // 10MB max
                }
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Process form data and handle file uploads
        if ($job->application_form) {
            foreach ($job->application_form as $field) {
                $fieldKey = str_replace(' ', '_', strtolower($field['label']));
                $fieldName = 'form_data.' . $fieldKey;

                if ($field['type'] === 'file' && $request->hasFile($fieldName)) {
                    // Store file in storage/app/public/applications
                    $file = $request->file($fieldName);
                    $filename = time() . '_' . $fieldKey . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('applications', $filename, 'public');
                    $formData[$fieldKey] = $path;
                } else {
                    $formData[$fieldKey] = $request->input($fieldName);
                }
            }
        }

        // Create the application
        Application::create([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'form_data' => $formData,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        return back()->with('success', 'Your application has been submitted successfully!');
    }

    public function myApplications()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $applications = Application::where('user_id', Auth::id())
            ->with('job')
            ->orderBy('applied_at', 'desc')
            ->paginate(10);

        return view('jobs.my-applications', compact('applications'));
    }
}
