<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Filament\Tables\Filters\SelectFilter;
use Filament\Tables;

class AnswerFilter
{
    public static function make(): SelectFilter
    {
        return SelectFilter::make('answer')
            ->label(\__('feedbackie-core::labels.filters.answer'))
            ->options([
                'yes' => \__('feedbackie-core::labels.general.yes'),
                'no' => \__('feedbackie-core::labels.general.yes'),
            ]);
    }
}
