<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\FeedbackResource\Pages;

use Feedbackie\Core\Filament\Pages\SiteDependentListRecords;
use Feedbackie\Core\Filament\Resources\FeedbackResource;

class ListFeedbacks extends SiteDependentListRecords
{
    protected static string $resource = FeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
