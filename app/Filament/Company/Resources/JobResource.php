<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\JobResource\Pages;
use App\Filament\Company\Resources\JobResource\RelationManagers;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Job Management';

    protected static ?string $navigationLabel = 'My Jobs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('company')
                    ->required()
                    ->maxLength(255)
                    ->default(fn() => Auth::user()->name),

                Forms\Components\Select::make('location')
                    ->required()
                    ->options([
                        'Martapura' => 'Martapura',
                        'Belitang' => 'Belitang',
                        'Belitang Hilir' => 'Belitang Hilir',
                        'Belitang Hulu' => 'Belitang Hulu',
                        'Belitang Jaya' => 'Belitang Jaya',
                        'Cit' => 'Cit',
                        'Pedamaran' => 'Pedamaran',
                        'Semendawai Suku III' => 'Semendawai Suku III',
                        'Semendawai Timur' => 'Semendawai Timur',
                        'Sirah Pulau Padang' => 'Sirah Pulau Padang',
                        'Sosok' => 'Sosok',
                    ]),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('salary')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),

                Forms\Components\DatePicker::make('deadline')
                    ->required()
                    ->minDate(now()),

                Forms\Components\Toggle::make('is_active')
                    ->default(true),

                Forms\Components\Repeater::make('application_form')
                    ->label('Application Form Fields')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->required()
                            ->placeholder('Field Label (e.g., CV, Portfolio)'),

                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'text' => 'Text Input',
                                'textarea' => 'Textarea',
                                'number' => 'Number',
                                'email' => 'Email',
                                'file' => 'File Upload',
                                'select' => 'Select Dropdown',
                                'radio' => 'Radio Buttons',
                                'checkbox' => 'Checkbox',
                            ]),

                        Forms\Components\Textarea::make('options')
                            ->label('Options (for select/radio/checkbox)')
                            ->placeholder('Option 1, Option 2, Option 3')
                            ->visible(fn(Forms\Get $get) => in_array($get('type'), ['select', 'radio', 'checkbox'])),

                        Forms\Components\Toggle::make('required')
                            ->default(false),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),

                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->searchable(),

                Tables\Columns\TextColumn::make('salary')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('applications_count')
                    ->counts('applications')
                    ->label('Applications')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('location')
                    ->options([
                        'Martapura' => 'Martapura',
                        'Belitang' => 'Belitang',
                        'Belitang Hilir' => 'Belitang Hilir',
                        'Belitang Hulu' => 'Belitang Hulu',
                        'Belitang Jaya' => 'Belitang Jaya',
                        'Cit' => 'Cit',
                        'Pedamaran' => 'Pedamaran',
                        'Semendawai Suku III' => 'Semendawai Suku III',
                        'Semendawai Timur' => 'Semendawai Timur',
                        'Sirah Pulau Padang' => 'Sirah Pulau Padang',
                        'Sosok' => 'Sosok',
                    ]),

                Filter::make('salary_range')
                    ->form([
                        Forms\Components\TextInput::make('salary_min')
                            ->numeric()
                            ->label('Minimum Salary'),
                        Forms\Components\TextInput::make('salary_max')
                            ->numeric()
                            ->label('Maximum Salary'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['salary_min'],
                                fn(Builder $query, $salary): Builder => $query->where('salary', '>=', $salary),
                            )
                            ->when(
                                $data['salary_max'],
                                fn(Builder $query, $salary): Builder => $query->where('salary', '<=', $salary),
                            );
                    }),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        // Companies can only see their own jobs
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ApplicationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'view' => Pages\ViewJob::route('/{record}'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
