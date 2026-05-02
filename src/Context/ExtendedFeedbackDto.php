<?php

declare(strict_types=1);

namespace Feedbackie\Core\Context;

use Spatie\LaravelData\Data;

class ExtendedFeedbackDto extends Data
{
    public function __construct(
        public array   $options = [],
        public ?string $comment = null,
    ) {}
}
