<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Filament\Tables\Filters\Filter;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;

class UrlFilter
{
    public static function make(): Filter
    {
        return Tables\Filters\Filter::make('url')
            ->form([
                Forms\Components\TextInput::make('url')
                    ->label(\__('feedbackie-core::labels.filters.url')),
            ])
            ->indicateUsing(function ($data) {
                if (empty($data['url']) === false) {
                    return \__('feedbackie-core::labels.filters.url') . ": " . $data['url'];
                }

                return null;
            })
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['url'],
                        fn(Builder $query, $url): Builder => $query->where('url', 'like', '%' . $url . '%'),
                    );
            });
    }
}
