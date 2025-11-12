<?php

declare(strict_types=1);

namespace Feedbackie\Core\Utils;

class Uuid
{
    private const VALID_PATTERN = '\A[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}\z';

    public static function getRegex(): string
    {
        return self::VALID_PATTERN;
    }
}
