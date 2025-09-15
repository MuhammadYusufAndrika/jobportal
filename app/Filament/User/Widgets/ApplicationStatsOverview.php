<?php

namespace App\Filament\User\Widgets;

use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ApplicationStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        $totalApplications = Application::where('user_id', $userId)->count();
        $pendingApplications = Application::where('user_id', $userId)->where('status', 'pending')->count();
        $acceptedApplications = Application::where('user_id', $userId)->where('status', 'accepted')->count();
        $rejectedApplications = Application::where('user_id', $userId)->where('status', 'rejected')->count();

        return [
            Stat::make('Total Applications', $totalApplications)
                ->description('All your job applications')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Pending Review', $pendingApplications)
                ->description('Waiting for company response')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Accepted', $acceptedApplications)
                ->description('Congratulations!')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Rejected', $rejectedApplications)
                ->description('Keep trying!')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
