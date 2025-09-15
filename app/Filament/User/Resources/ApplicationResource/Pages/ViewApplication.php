<?php

namespace App\Filament\User\Resources\ApplicationResource\Pages;

use App\Filament\User\Resources\ApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewApplication extends ViewRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No edit action since applications are read-only for users
        ];
    }
}
