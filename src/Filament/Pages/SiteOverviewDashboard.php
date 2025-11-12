<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Pages;

use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Widgets\FeedbackChart;
use Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Widgets\FeedbackOverview;
use Feedbackie\Core\Filament\Resources\ReportResource\Widgets\ReportsChart;
use Feedbackie\Core\Filament\Resources\ReportResource\Widgets\ReportsOverview;
use Feedbackie\Core\Filament\Traits\InteractsWithSiteSelector;
use Filament\Pages\Dashboard as BaseDashboard;

class SiteOverviewDashboard extends BaseDashboard
{
    use InteractsWithSiteSelector;

    protected static string $routePath = '/dashboard';

    protected static ?int $navigationSort = -2;

    public function getTitle(): string
    {
        return \__('feedbackie-core::labels.pages.overview.title');
    }

    public function getWidgets(): array
    {
        return [
            FeedbackOverview::class,
            ReportsOverview::class,
            FeedbackChart::class,
            ReportsChart::class,
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return FeedbackieConfiguration::isRouteSiteDependent();
    }
}
