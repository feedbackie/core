<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Feedbackie\Core\Enums\FeedbackOptions;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;

class OptionsFilter
{
    public static function make(): Filter
    {
        return Filter::make('options')
            ->schema([
                Select::make('selected_option')
                    ->label(\__('feedbackie-core::labels.filters.options'))
                    ->options(FeedbackOptions::toArray()),
            ])
            ->indicateUsing(function ($data) {
                if (empty($data['selected_option']) === false) {
                    return \__('feedbackie-core::labels.filters.option') . ": " . FeedbackOptions::from($data['selected_option'])->label();
                }

                return null;
            })
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['selected_option'],
                        fn(Builder $query, $date): Builder => $query->whereJsonContains('options', $data['option']),
                    );
            });
    }
}
