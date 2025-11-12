<?php

declare(strict_types=1);

namespace Feedbackie\Core\Context;

use Spatie\LaravelData\Data;

class TimestampsDto extends Data
{
    public function __construct(
        public ?string $ss,
        public ?int $ts,
        public ?int $ls,
    )
    {
    }
}
