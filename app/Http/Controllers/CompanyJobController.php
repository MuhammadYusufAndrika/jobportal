<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyJobController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        $jobs = Job::where('user_id', Auth::id())
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('company.jobs.index', compact('jobs'));
    }

    public function create()
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        $locations = [
            'Martapura',
            'Belitang',
            'Belitang Hilir',
            'Belitang Hulu',
            'Belitang Jaya',
            'Cit',
            'Pedamaran',
            'Semendawai Suku III',
            'Semendawai Timur',
            'Sirah Pulau Padang',
            'Sosok'
        ];

        return view('company.jobs.create', compact('locations'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary' => 'nullable|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,contract,internship',
            'deadline' => 'required|date|after:today',
            'application_form' => 'nullable|array',
            'application_form.*.label' => 'required|string',
            'application_form.*.type' => 'required|in:text,email,number,textarea,select,file',
            'application_form.*.required' => 'boolean',
            'application_form.*.options' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Process application form
        $applicationForm = [];
        if ($request->has('application_form')) {
            foreach ($request->application_form as $field) {
                $formField = [
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'required' => isset($field['required']) ? true : false,
                ];

                if ($field['type'] === 'select' && !empty($field['options'])) {
                    $formField['options'] = array_map('trim', explode(',', $field['options']));
                }

                $applicationForm[] = $formField;
            }
        }

        Job::create([
            'title' => $request->title,
            'company' => $request->company,
            'location' => $request->location,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'salary' => $request->salary,
            'employment_type' => $request->employment_type,
            'deadline' => $request->deadline,
            'application_form' => $applicationForm,
            'is_active' => true,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('company.jobs.index')->with('success', 'Job created successfully!');
    }

    public function show(Job $job)
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        if ($job->user_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        $job->load(['applications.user']);

        return view('company.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        if ($job->user_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        $locations = [
            'Martapura',
            'Belitang',
            'Belitang Hilir',
            'Belitang Hulu',
            'Belitang Jaya',
            'Cit',
            'Pedamaran',
            'Semendawai Suku III',
            'Semendawai Timur',
            'Sirah Pulau Padang',
            'Sosok'
        ];

        return view('company.jobs.edit', compact('job', 'locations'));
    }

    public function update(Request $request, Job $job)
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        if ($job->user_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary' => 'nullable|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,contract,internship',
            'deadline' => 'required|date',
            'is_active' => 'boolean',
            'application_form' => 'nullable|array',
            'application_form.*.label' => 'required|string',
            'application_form.*.type' => 'required|in:text,email,number,textarea,select,file',
            'application_form.*.required' => 'boolean',
            'application_form.*.options' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Process application form
        $applicationForm = [];
        if ($request->has('application_form')) {
            foreach ($request->application_form as $field) {
                $formField = [
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'required' => isset($field['required']) ? true : false,
                ];

                if ($field['type'] === 'select' && !empty($field['options'])) {
                    $formField['options'] = array_map('trim', explode(',', $field['options']));
                }

                $applicationForm[] = $formField;
            }
        }

        $job->update([
            'title' => $request->title,
            'company' => $request->company,
            'location' => $request->location,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'salary' => $request->salary,
            'employment_type' => $request->employment_type,
            'deadline' => $request->deadline,
            'application_form' => $applicationForm,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('company.jobs.show', $job)->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        if (!Auth::check() || !Auth::user()->hasRole('company')) {
            abort(403, 'Access denied. Company role required.');
        }

        if ($job->user_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        $job->delete();

        return redirect()->route('company.jobs.index')->with('success', 'Job deleted successfully!');
    }
}
