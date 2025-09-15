<?php

namespace App\Filament\Company\Resources\ApplicationResource\Pages;

use App\Filament\Company\Resources\ApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Companies shouldn't create applications manually
        ];
    }
}
