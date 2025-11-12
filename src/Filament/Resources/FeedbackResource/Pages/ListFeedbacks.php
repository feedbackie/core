<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\FeedbackResource\Pages;

use Feedbackie\Core\Filament\Resources\FeedbackResource;
use Feedbackie\Core\Filament\Traits\InteractsWithSiteSelector;
use Feedbackie\Core\Filament\Traits\ScopedByCurrentSite;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListFeedbacks extends ListRecords
{
    use InteractsWithSiteSelector;
    use ScopedByCurrentSite;

    protected static string $resource = FeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
