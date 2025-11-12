<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Traits;

trait HasLabelsWithoutTitleCase
{
    public abstract static function getModelLabel(): string;

    public abstract static function getPluralModelLabel(): string;

    public static function getTitleCaseModelLabel(): string
    {
        return static::getModelLabel();
    }

    public static function getTitleCasePluralModelLabel(): string
    {
        return self::getPluralModelLabel();
    }
}
