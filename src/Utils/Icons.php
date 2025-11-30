<?php

declare(strict_types=1);

namespace Feedbackie\Core\Utils;

class Icons
{
    public static function getCountryFlagByCode(string $countryCode): string
    {
        if(strlen($countryCode) > 2) {
            return '';
        }

        $countryCode = strtoupper($countryCode);

        $firstLetter = mb_chr(0x1F1E6 + ord($countryCode[0]) - ord('A'));
        $secondLetter = mb_chr(0x1F1E6 + ord($countryCode[1]) - ord('A'));

        return $firstLetter . $secondLetter;
    }
}
