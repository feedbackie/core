<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\ReportStats\Pages;

use Feedbackie\Core\Filament\Pages\SiteDependentListRecords;
use Feedbackie\Core\Filament\Resources\Reports\Widgets\ReportsOverview;
use Feedbackie\Core\Filament\Resources\ReportStats\ReportStatsResource;
use Feedbackie\Core\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ListReportStats extends SiteDependentListRecords
{
    protected static string $resource = ReportStatsResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTableRecordKey(Model|array $record): string
    {
        return $record->url;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReportsOverview::class,
        ];
    }
}
