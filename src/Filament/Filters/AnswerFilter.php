<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Filament\Tables;

class AnswerFilter
{
    public static function make(): Tables\Filters\SelectFilter
    {
        return Tables\Filters\SelectFilter::make('answer')
            ->label(\__('feedbackie-core::labels.filters.answer'))
            ->options([
                'yes' => \__('feedbackie-core::labels.general.yes'),
                'no' => \__('feedbackie-core::labels.general.yes'),
            ]);
    }
}
