<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\ReportResource\Pages;

use Feedbackie\Core\Filament\Resources\ReportResource;
use Feedbackie\Core\Filament\Traits\InteractsWithSiteSelector;
use Feedbackie\Core\Filament\Traits\ScopedByCurrentSite;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords
{
    use InteractsWithSiteSelector;
    use ScopedByCurrentSite;

    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
