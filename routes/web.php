<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\CompanyJobController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    Route::get('/my-applications', [JobController::class, 'myApplications'])->name('jobs.my-applications');

    // Company Dashboard Routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
        Route::get('/applications', [CompanyDashboardController::class, 'applications'])->name('applications');
        Route::get('/applications/{application}', [CompanyDashboardController::class, 'showApplication'])->name('application.show');
        Route::patch('/applications/{application}/status', [CompanyDashboardController::class, 'updateApplicationStatus'])->name('application.update-status');

        // Company Job Management Routes
        Route::resource('jobs', CompanyJobController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
})->name('admin');

require __DIR__ . '/auth.php';
