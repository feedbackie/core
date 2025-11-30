<?php

declare(strict_types=1);

namespace Feedbackie\Core\Utils;

class Hash
{
    public static function md5ToNumber(?string $hash): int
    {
        if(null === $hash) {
            return 0;
        }

        $sum = 0;

        for ($i = 0; $i < strlen($hash); $i++) {
            $sum += ord($hash[$i]);
        }

        return ($sum % 9) + 1;
    }
}
