<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Filament\Forms\Components\Checkbox;
use Filament\Tables\Filters\Filter;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class HasOptionsFilter
{
    public static function make(): Filter
    {
        return Filter::make('Has options')
            ->schema([
                Checkbox::make('has_options')
                    ->label(\__('feedbackie-core::labels.filters.has_options'))
            ])
            ->indicateUsing(function ($data) {
                if (empty($data['has_options']) === false) {
                    return \__('feedbackie-core::labels.filters.has_options');
                }

                return null;
            })
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['has_options'],
                        fn(Builder $query, $date): Builder => $query->whereJsonLength('options', '>', 0),
                    );
            });
    }
}
