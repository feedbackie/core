<?php

declare(strict_types=1);

namespace Feedbackie\Core\Context;

class CountryDto
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $code = null,
    ){}
}
