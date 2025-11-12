<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\SiteResource\Pages;

use Feedbackie\Core\Filament\Resources\SiteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSite extends CreateRecord
{
    protected static string $resource = SiteResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
