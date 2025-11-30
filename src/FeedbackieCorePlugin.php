<?php

declare(strict_types=1);

namespace Feedbackie\Core;

use Feedbackie\Core\Filament\Pages\SiteOverviewDashboard;
use Feedbackie\Core\Filament\Resources\ReportResource\Widgets\ReportsOverview;
use Feedbackie\Core\Filament\Resources\FeedbackResource;
use Feedbackie\Core\Filament\Resources\FeedbackStatsResource;
use Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Widgets\FeedbackChart;
use Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Widgets\FeedbackOverview;
use Feedbackie\Core\Filament\Resources\ReportResource;
use Feedbackie\Core\Filament\Resources\ReportResource\Widgets\ReportsChart;
use Feedbackie\Core\Filament\Resources\ReportStatsResource;
use Feedbackie\Core\Filament\Resources\SiteResource;
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

