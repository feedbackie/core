<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\Reports\Pages;

use Feedbackie\Core\Filament\Pages\SiteDependentListRecords;
use Feedbackie\Core\Filament\Resources\Reports\ReportResource;

class ListReports extends SiteDependentListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
