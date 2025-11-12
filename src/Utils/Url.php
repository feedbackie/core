<?php

declare(strict_types=1);

namespace Feedbackie\Core\Utils;

use Illuminate\Support\Str;

class Url
{
    public static function sanitize(string $url): string
    {
        $data = \Spatie\Url\Url::fromString($url);

        if ($data->getPort() !== 80 && !empty($data->getPort())) {
            $url = $data->getScheme() . "://" . $data->getHost() . ":" . $data->getPort() . $data->getPath();
        } else {
            $url = $data->getScheme() . "://" . $data->getHost() . $data->getPath();
        }

        return Str::replaceEnd("/", "", $url);
    }
}
