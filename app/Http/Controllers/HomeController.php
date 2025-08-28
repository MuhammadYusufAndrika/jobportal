<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get featured jobs (latest 6 active jobs)
        $featuredJobs = Job::query()
            ->where('is_active', true)
            ->where('deadline', '>=', now()->toDateString())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Statistics
        $totalJobs = Job::where('is_active', true)
            ->where('deadline', '>=', now()->toDateString())
            ->count();

        $totalCompanies = Job::distinct('company')->count();

        $totalApplications = Application::count();

        // Jobs by location
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

        $jobsByLocation = [];
        foreach ($locations as $location) {
            $jobsByLocation[$location] = Job::where('location', $location)
                ->where('is_active', true)
                ->where('deadline', '>=', now()->toDateString())
                ->count();
        }

        return view('home', compact(
            'featuredJobs',
            'totalJobs',
            'totalCompanies',
            'totalApplications',
            'jobsByLocation'
        ));
    }
}
