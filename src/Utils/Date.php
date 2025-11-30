<?php

declare(strict_types=1);

namespace Feedbackie\Core\Utils;

class Date
{
    public static function formatSeconds(int $seconds): string
    {
        $duration = $seconds;
        $hours = 0;
        $minutes = 0;

        if ($duration >= 3600) {
            $hours = floor($duration / 3600);
            $duration = $duration - (floor($duration / 3600) * 3600);
        }

        if ($duration >= 60) {
            $minutes = floor($duration / 60);
            $duration = $duration - (floor($duration / 60) * 60);
        }

        if ($hours > 0) {
            return sprintf('%dh %dm %ds', $hours, $minutes, $duration);
        } elseif ($minutes > 0) {
            return sprintf('%dm %ds', $minutes, $duration);
        } else {
            return sprintf('%ds', $duration);
        }
    }
}
