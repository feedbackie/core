<?php

declare(strict_types=1);

namespace Feedbackie\Core\Context;

class FeedbackStatsDto
{
    public function __construct(
        public readonly int $useful,
        public readonly int $notUseful,
    ) {}
}
