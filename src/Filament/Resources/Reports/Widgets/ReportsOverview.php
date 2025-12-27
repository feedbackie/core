<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\Reports\Widgets;

use Feedbackie\Core\Filament\Traits\InteractsWithSiteSelector;
use Feedbackie\Core\Models\Report;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportsOverview extends BaseWidget
{
    use InteractsWithSiteSelector;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $total = Report::query()
            ->currentSite()
            ->count();

        $archived = Report::query()
            ->whereNotNull("deleted_at")
            ->withTrashed()
            ->currentSite()
            ->count();

        $withComment = Report::query()
            ->where("comment", "<>", "")
            ->currentSite()
            ->count();

        return [
            Stat::make(\__('feedbackie-core::labels.resources.report_stats.total_reports_count'), $total),
            Stat::make(\__('feedbackie-core::labels.resources.report_stats.has_comment_count'), $withComment)->color("info"),
            Stat::make(\__('feedbackie-core::labels.resources.report_stats.archived_reports_count'), $archived)->color("danger"),
        ];
    }
}
