<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Pages;

use Feedbackie\Core\Filament\Resources\FeedbackStatsResource;
use Feedbackie\Core\Filament\Traits\InteractsWithSiteSelector;
use Feedbackie\Core\Filament\Traits\ScopedByCurrentSite;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;

class ListFeedbackStats extends ListRecords
{
    use InteractsWithSiteSelector;
    use ScopedByCurrentSite;

    protected static string $resource = FeedbackStatsResource::class;

    public function getTableRecordKey(Model $record): string
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
            FeedbackStatsResource\Widgets\FeedbackOverview::class,
        ];
    }
}
