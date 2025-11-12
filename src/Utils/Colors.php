<?php

declare(strict_types=1);

namespace Feedbackie\Core\Utils;

use Filament\Support\Colors\Color;

class Colors
{
    public static function getColorsDefinition(): array
    {
        return [
            'fuchsia' => Color::Fuchsia,
            'orange' => Color::Orange,
            'amber' => Color::Amber,
            'lime' => Color::Lime,
            'emerald' => Color::Emerald,
            'teal' => Color::Teal,
            'cyan' => Color::Cyan,
            'sky' => Color::Sky,
            'indigo' => Color::Indigo,
        ];
    }

    public static function getColors(): array
    {
        return [
            'grey',
            'fuchsia',
            'orange',
            'amber',
            'lime',
            'emerald',
            'teal',
            'cyan',
            'sky',
            'indigo',
        ];
    }
}
