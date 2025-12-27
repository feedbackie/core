<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\FeedbackStats\Pages;

use Feedbackie\Core\Filament\Pages\SiteDependentListRecords;
use Feedbackie\Core\Filament\Resources\FeedbackStats\FeedbackStatsResource;
use Feedbackie\Core\Filament\Resources\FeedbackStats\Widgets\FeedbackOverview;
use Illuminate\Database\Eloquent\Model;

class ListFeedbackStats extends SiteDependentListRecords
{
    protected static string $resource = FeedbackStatsResource::class;

    public function getTableRecordKey(Model|array $record): string
    {
        return $record->url;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FeedbackOverview::class,
        ];
    }
}
