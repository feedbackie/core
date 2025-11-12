<?php

declare(strict_types=1);

namespace Feedbackie\Core\Context;

use App\Models\Site;
use Spatie\LaravelData\Data;

class FeedbackDto extends Data
{
    public function __construct(
        public string $answer,
        public string $url,
        public string $hash,
        public string $url_hash,
    )
    {
    }

    public function excludeProperties(): array
    {
        return ["site"];
    }
}
