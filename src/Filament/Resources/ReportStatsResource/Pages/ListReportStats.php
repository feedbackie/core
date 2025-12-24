<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\ReportStatsResource\Pages;

use Feedbackie\Core\Filament\Pages\SiteDependentListRecords;
use Feedbackie\Core\Filament\Resources\ReportResource\Widgets\ReportsOverview;
use Feedbackie\Core\Filament\Resources\ReportStatsResource;
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

    protected function getTableQuery(): Builder
    {
        return Report::select("url")
            ->orderBy('total', 'desc')
            ->groupBy("url")
            ->selectRaw("count(*) as total")
            ->selectRaw("count(*) FILTER (WHERE LENGTH(comment) > 0) AS comments_count");
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReportsOverview::class,
        ];
    }
}
