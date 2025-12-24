<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Widgets;

use Feedbackie\Core\Filament\Traits\InteractsWithSiteSelector;
use Feedbackie\Core\Models\Feedback;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FeedbackOverview extends BaseWidget
{
    use InteractsWithSiteSelector;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $total = Feedback::query()
            ->currentSite()
            ->count();

        $positive = Feedback::query()
            ->where("answer", "yes")
            ->currentSite()
            ->count();

        $negative = Feedback::query()
            ->where("answer", "no")
            ->currentSite()
            ->count();
        $withOptions = Feedback::query()
            ->whereJsonLength("options", '>', 0)
            ->currentSite()
            ->count();

        if ($total > 0) {
            $positivePercent = round($positive * 100 / $total, 2);
            $negativePercent = round($negative * 100 / $total, 2);
            $withOptionsPercent = round($negative * 100 / $total, 2);
        } else {
            $positivePercent = $negativePercent = $withOptionsPercent = 0;
        }

        return [
            Stat::make(\__('feedbackie-core::labels.resources.feedback_stats.total_feedback_count'), $total),
            Stat::make(\__('feedbackie-core::labels.resources.feedback_stats.yes_count'), $positive)->description($positivePercent . '%'),
            Stat::make(\__('feedbackie-core::labels.resources.feedback_stats.no_count'), $negative)->description($negativePercent . '%'),
            Stat::make(\__('feedbackie-core::labels.resources.feedback_stats.selected_options_count'), $withOptions)->description($withOptionsPercent . '%'),
        ];
    }
}
