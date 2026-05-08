<?php

declare(strict_types=1);

namespace Feedbackie\Core\Contracts;

use Feedbackie\Core\Context\FeedbackStatsDto;
use Feedbackie\Core\Models\Site;

interface CanRetrieveFeedbackStats
{
    public function getFeedbackStatsByUrl(Site $site, string $url): FeedbackStatsDto;
}
