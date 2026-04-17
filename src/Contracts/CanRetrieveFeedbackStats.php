<?php

declare(strict_types=1);

namespace Feedbackie\Core\Contracts;

use Feedbackie\Core\Context\FeedbackStatsDto;

interface CanRetrieveFeedbackStats
{
    public function getFeedbackStatsByUrl(string $url): FeedbackStatsDto;
}
