<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\ApplicationResource\Pages;
use App\Filament\Company\Resources\ApplicationResource\RelationManagers;
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

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Application Management';

    protected static ?string $navigationLabel = 'Job Applications';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('job_id')
                    ->relationship('job', 'title', function (Builder $query) {
                        // Only show jobs created by this company
                        $query->where('user_id', Auth::id());
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(), // Companies shouldn't change which job the application is for

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(), // Companies shouldn't change the applicant

                Forms\Components\Section::make('Application Data')
                    ->schema([
                        Forms\Components\View::make('filament.forms.components.application-data')
                            ->viewData(function ($record) {
                                $formData = $record->form_data ?? [];
                                $formattedData = [];

                                foreach ($formData as $key => $value) {
                                    $formattedData[] = [
                                        'field' => ucwords(str_replace('_', ' ', $key)),
                                        'value' => $value,
                                        'is_file' => is_string($value) && str_starts_with($value, 'applications/'),
                                        'file_url' => is_string($value) && str_starts_with($value, 'applications/') ? Storage::url($value) : null,
                                        'file_name' => is_string($value) && str_starts_with($value, 'applications/') ? basename($value) : null,
                                        'file_extension' => is_string($value) && str_starts_with($value, 'applications/') ? pathinfo(basename($value), PATHINFO_EXTENSION) : null,
                                    ];
                                }

                                return ['application_data' => $formattedData];
                            })
                    ])
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Internal Notes')
                    ->columnSpanFull()
                    ->placeholder('Add internal notes about this application...'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job.title')
                    ->label('Job Position')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Applicant')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'reviewed',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('applied_at')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('files_count')
                    ->label('Attachments')
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

                Tables\Columns\TextColumn::make('notes')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
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

                SelectFilter::make('job')
                    ->relationship('job', 'title', function (Builder $query) {
                        // Only show jobs created by this company
                        $query->where('user_id', Auth::id());
                    })
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form([
                        Forms\Components\TextInput::make('job.title')
                            ->label('Job Position')
                            ->disabled(),
                        Forms\Components\TextInput::make('user.name')
                            ->label('Applicant Name')
                            ->disabled(),
                        Forms\Components\TextInput::make('user.email')
                            ->label('Email')
                            ->disabled(),
                        Forms\Components\Section::make('Application Data')
                            ->schema([
                                Forms\Components\View::make('filament.forms.components.application-data')
                                    ->viewData(function ($record) {
                                        $formData = $record->form_data ?? [];
                                        $formattedData = [];

                                        foreach ($formData as $key => $value) {
                                            $formattedData[] = [
                                                'field' => ucwords(str_replace('_', ' ', $key)),
                                                'value' => $value,
                                                'is_file' => is_string($value) && str_starts_with($value, 'applications/'),
                                                'file_url' => is_string($value) && str_starts_with($value, 'applications/') ? Storage::url($value) : null,
                                                'file_name' => is_string($value) && str_starts_with($value, 'applications/') ? basename($value) : null,
                                                'file_extension' => is_string($value) && str_starts_with($value, 'applications/') ? pathinfo(basename($value), PATHINFO_EXTENSION) : null,
                                            ];
                                        }

                                        return ['application_data' => $formattedData];
                                    })
                            ])
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Internal Notes')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_reviewed')
                        ->label('Mark as Reviewed')
                        ->icon('heroicon-o-eye')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'reviewed']);
                            });
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('mark_accepted')
                        ->label('Mark as Accepted')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'accepted']);
                            });
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('mark_rejected')
                        ->label('Mark as Rejected')
                        ->icon('heroicon-o-x-circle')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'rejected']);
                            });
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('applied_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        // Companies can only see applications for their jobs
        return parent::getEloquentQuery()->whereHas('job', function ($query) {
            $query->where('user_id', Auth::id());
        });
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
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
