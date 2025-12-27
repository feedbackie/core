<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\Sites\Pages;

use Feedbackie\Core\Filament\Resources\Sites\SiteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSites extends ListRecords
{
    protected static string $resource = SiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
