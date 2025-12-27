<?php

declare(strict_types=1);

namespace Feedbackie\Core;

use Feedbackie\Core\Filament\Pages\SiteOverviewDashboard;
use Feedbackie\Core\Filament\Resources\Feedback\FeedbackResource;
use Feedbackie\Core\Filament\Resources\FeedbackStats\FeedbackStatsResource;
use Feedbackie\Core\Filament\Resources\FeedbackStats\Widgets\FeedbackChart;
use Feedbackie\Core\Filament\Resources\FeedbackStats\Widgets\FeedbackOverview;
use Feedbackie\Core\Filament\Resources\Reports\ReportResource;
use Feedbackie\Core\Filament\Resources\Reports\Widgets\ReportsChart;
use Feedbackie\Core\Filament\Resources\Reports\Widgets\ReportsOverview;
use Feedbackie\Core\Filament\Resources\ReportStats\ReportStatsResource;
use Feedbackie\Core\Filament\Resources\Sites\SiteResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FeedbackieCorePlugin implements Plugin
{
    public function getId(): string
    {
        return 'feedbackie-core';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                FeedbackResource::class,
                FeedbackStatsResource::class,
                ReportResource::class,
                ReportStatsResource::class,
                SiteResource::class,
            ])
            ->widgets([
                FeedbackOverview::class,
                ReportsOverview::class,
                FeedbackChart::class,
                ReportsChart::class,
            ])
            ->pages([
                SiteOverviewDashboard::class
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }
}

