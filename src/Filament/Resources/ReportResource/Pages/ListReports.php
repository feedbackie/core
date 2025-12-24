<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\ReportResource\Pages;

use Feedbackie\Core\Filament\Pages\SiteDependentListRecords;
use Feedbackie\Core\Filament\Resources\ReportResource;

class ListReports extends SiteDependentListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
