<?php

namespace App\Filament\Company\Resources\JobResource\Pages;

use App\Filament\Company\Resources\JobResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;
}
