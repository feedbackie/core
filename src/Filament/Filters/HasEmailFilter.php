<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Filament\Forms\Components\Checkbox;
use Filament\Tables\Filters\Filter;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class HasEmailFilter
{
    public static function make(): Filter
    {
        return Filter::make('Has Email')
            ->schema([
                Checkbox::make('has_email')
                    ->label(\__('feedbackie-core::labels.filters.has_email')),
            ])
            ->indicateUsing(function ($data) {
                if (empty($data['has_email']) === false) {
                    return \__('feedbackie-core::labels.filters.has_email');
                }

                return null;
            })
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['has_email'],
                        fn(Builder $query, $date): Builder => $query->whereRaw("LENGTH(email) > 0"),
                    );
            });
    }
}
