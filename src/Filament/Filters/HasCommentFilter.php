<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Filament\Forms\Components\Checkbox;
use Filament\Tables\Filters\Filter;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class HasCommentFilter
{
    public static function make(): Filter
    {
        return Tables\Filters\Filter::make('Has comments')
            ->form([
                Checkbox::make('has_comment')
                    ->label(\__('feedbackie-core::labels.filters.has_comment'))
            ])
            ->indicateUsing(function ($data) {
                if (empty($data['has_comment']) === false) {
                    return \__('feedbackie-core::labels.filters.has_comment');
                }

                return null;
            })
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['has_comment'],
                        fn(Builder $query, $date): Builder => $query->whereRaw("LENGTH(comment) > 0"),
                    );
            });
    }
}
