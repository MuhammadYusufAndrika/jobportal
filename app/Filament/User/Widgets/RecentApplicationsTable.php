<?php

namespace App\Filament\User\Widgets;

use App\Models\Application;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentApplicationsTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Applications';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Application::where('user_id', Auth::id())
                    ->with(['job'])
                    ->latest('applied_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('job.title')
                    ->label('Job Position')
                    ->weight('bold')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('job.company')
                    ->label('Company')
                    ->icon('heroicon-m-building-office-2'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'reviewed',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('applied_at')
                    ->label('Applied')
                    ->since()
                    ->icon('heroicon-m-calendar'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn(Application $record): string => route('filament.user.resources.applications.view', $record)),
            ])
            ->paginated(false);
    }
}
