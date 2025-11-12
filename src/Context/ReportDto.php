<?php

declare(strict_types=1);

namespace Feedbackie\Core\Context;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapOutputName(SnakeCaseMapper::class)]
class ReportDto extends Data
{
    public function __construct(
        public string $url,
        public ?string $selectedText,
        public ?string $fullText,
        public ?string $fixedText,
        public ?string $comment = null,
        public int $offset = 0,
    )
    {
    }
}
