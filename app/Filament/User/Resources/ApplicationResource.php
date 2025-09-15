<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\ApplicationResource\Pages;
use App\Filament\User\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Filament\Support\Enums\FontWeight;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'My Applications';

    protected static ?string $navigationLabel = 'Job Applications';

    protected static ?string $modelLabel = 'Application';

    protected static ?string $pluralModelLabel = 'Applications';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Job Information')
                    ->schema([
                        Forms\Components\TextInput::make('job.title')
                            ->label('Job Position')
                            ->disabled(),

                        Forms\Components\TextInput::make('job.company')
                            ->label('Company')
                            ->disabled(),

                        Forms\Components\TextInput::make('job.location')
                            ->label('Location')
                            ->disabled(),

                        Forms\Components\TextInput::make('job.salary')
                            ->label('Salary')
                            ->prefix('Rp')
                            ->disabled(),

                        Forms\Components\DatePicker::make('job.deadline')
                            ->label('Application Deadline')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Application Status')
                    ->schema([
                        Forms\Components\TextInput::make('status')
                            ->label('Current Status')
                            ->disabled()
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'pending' => 'warning',
                                'reviewed' => 'info',
                                'accepted' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),

                        Forms\Components\DateTimePicker::make('applied_at')
                            ->label('Application Date')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Application Data')
                    ->schema([
                        Forms\Components\Placeholder::make('form_data_display')
                            ->label('Your Application Details')
                            ->content(function ($record) {
                                if (!$record || !$record->form_data) {
                                    return 'No application data available.';
                                }

                                $html = '<div class="space-y-3">';
                                foreach ($record->form_data as $key => $value) {
                                    $label = str_replace('_', ' ', ucwords($key));

                                    if (is_string($value) && str_starts_with($value, 'applications/')) {
                                        // This is a file path
                                        $fileName = basename($value);
                                        $fileUrl = Storage::url($value);
                                        $html .= "<div class='border-l-4 border-blue-500 pl-3'>";
                                        $html .= "<strong class='text-gray-700'>{$label}:</strong><br>";
                                        $html .= "<a href='{$fileUrl}' target='_blank' class='text-blue-600 hover:text-blue-800 underline flex items-center gap-1'>";
                                        $html .= "<svg class='w-4 h-4' fill='currentColor' viewBox='0 0 20 20'><path d='M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 11-4 0 2 2 0 014 0zm8-2a2 2 0 11-4 0 2 2 0 014 0z'/></svg>";
                                        $html .= " {$fileName}</a>";
                                        $html .= "</div>";
                                    } else {
                                        $html .= "<div class='border-l-4 border-gray-300 pl-3'>";
                                        $html .= "<strong class='text-gray-700'>{$label}:</strong><br>";
                                        $html .= "<span class='text-gray-600'>" . (is_array($value) ? implode(', ', $value) : $value) . "</span>";
                                        $html .= "</div>";
                                    }
                                }
                                $html .= '</div>';

                                return new \Illuminate\Support\HtmlString($html);
                            })
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job.title')
                    ->label('Job Position')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->color('primary'),

                Tables\Columns\TextColumn::make('job.company')
                    ->label('Company')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-building-office-2'),

                Tables\Columns\TextColumn::make('job.location')
                    ->label('Location')
                    ->searchable()
                    ->icon('heroicon-m-map-pin'),

                Tables\Columns\TextColumn::make('job.salary')
                    ->label('Salary')
                    ->money('IDR')
                    ->sortable()
                    ->icon('heroicon-m-banknotes'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'reviewed',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ])
                    ->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-m-clock',
                        'reviewed' => 'heroicon-m-eye',
                        'accepted' => 'heroicon-m-check-circle',
                        'rejected' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                Tables\Columns\TextColumn::make('applied_at')
                    ->label('Applied Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->icon('heroicon-m-calendar'),

                Tables\Columns\TextColumn::make('job.deadline')
                    ->label('Deadline')
                    ->date('M j, Y')
                    ->sortable()
                    ->color(fn($record) => $record->job->deadline < now() ? 'danger' : 'gray')
                    ->icon('heroicon-m-exclamation-triangle'),

                Tables\Columns\TextColumn::make('files_count')
                    ->label('Files')
                    ->getStateUsing(function ($record) {
                        if (!$record->form_data) return 0;

                        $fileCount = 0;
                        foreach ($record->form_data as $value) {
                            if (is_string($value) && str_starts_with($value, 'applications/')) {
                                $fileCount++;
                            }
                        }
                        return $fileCount;
                    })
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-paper-clip'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->multiple(),

                SelectFilter::make('job.company')
                    ->label('Company')
                    ->options(function () {
                        return Application::where('user_id', Auth::id())
                            ->with('job')
                            ->get()
                            ->pluck('job.company', 'job.company')
                            ->unique()
                            ->toArray();
                    })
                    ->multiple(),

                Tables\Filters\Filter::make('recent')
                    ->label('Recent Applications (Last 30 days)')
                    ->query(fn(Builder $query): Builder => $query->where('applied_at', '>=', now()->subDays(30))),

                Tables\Filters\Filter::make('active_jobs')
                    ->label('Active Jobs Only')
                    ->query(fn(Builder $query): Builder => $query->whereHas('job', function ($q) {
                        $q->where('deadline', '>=', now()->toDateString());
                    })),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Details')
                    ->icon('heroicon-m-eye'),

                Tables\Actions\Action::make('download_files')
                    ->label('Download Files')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->action(function ($record) {
                        // This would need a proper implementation to zip and download files
                        // For now, it shows the user where their files are
                        return redirect()->to('/storage/' . collect($record->form_data)->first(function ($value) {
                            return is_string($value) && str_starts_with($value, 'applications/');
                        }));
                    })
                    ->visible(function ($record) {
                        if (!$record->form_data) return false;

                        foreach ($record->form_data as $value) {
                            if (is_string($value) && str_starts_with($value, 'applications/')) {
                                return true;
                            }
                        }
                        return false;
                    }),
            ])
            ->bulkActions([
                // No bulk actions for users
            ])
            ->emptyStateHeading('No Applications Yet')
            ->emptyStateDescription('You haven\'t applied to any jobs yet. Browse available jobs and start applying!')
            ->emptyStateIcon('heroicon-o-document-text')
            ->defaultSort('applied_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        // Users can only see their own applications
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'view' => Pages\ViewApplication::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Users apply through job listings, not through Filament
    }

    public static function canEdit($record): bool
    {
        return false; // Applications are read-only for users
    }

    public static function canDelete($record): bool
    {
        return false; // Users cannot delete their applications
    }
}
