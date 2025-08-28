<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        $user = Auth::user();
        
        // Get jobs created by this company
        $jobs = Job::where('user_id', $user->id)
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get applications for company's jobs
        $applications = Application::whereHas('job', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['job', 'user'])
        ->orderBy('applied_at', 'desc')
        ->paginate(10);

        // Statistics
        $totalJobs = Job::where('user_id', $user->id)->count();
        $activeJobs = Job::where('user_id', $user->id)
            ->where('is_active', true)
            ->where('deadline', '>=', now())
            ->count();
        $totalApplications = Application::whereHas('job', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
        $pendingApplications = Application::whereHas('job', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->count();

        return view('company.dashboard', compact(
            'jobs', 
            'applications', 
            'totalJobs', 
            'activeJobs', 
            'totalApplications', 
            'pendingApplications'
        ));
    }

    public function applications()
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        $user = Auth::user();
        
        $applications = Application::whereHas('job', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['job', 'user'])
        ->orderBy('applied_at', 'desc')
        ->paginate(15);

        return view('company.applications', compact('applications'));
    }

    public function showApplication(Application $application)
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        $user = Auth::user();
        
        // Ensure this application belongs to a job posted by this company
        if ($application->job->user_id !== $user->id) {
            abort(403, 'Access denied.');
        }

        return view('company.application-detail', compact('application'));
    }

    public function updateApplicationStatus(Request $request, Application $application)
    {
        $user = Auth::user();
        
        // Ensure this application belongs to a job posted by this company
        if ($application->job->user_id !== $user->id) {
            abort(403, 'Access denied.');
        }

        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        $application->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Application status updated successfully!');
    }
}
