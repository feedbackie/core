<?php

declare(strict_types=1);

namespace Feedbackie\Core\Context;

use Spatie\LaravelData\Data;

class ExtendedFeedbackDto extends Data
{
    public function __construct(
        public array   $options = [],
        public ?int    $languageScore = null,
        public ?string $comment = null,
        public ?string $email = null,
    ) {}
}
