<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;

class CreatedAtFilter
{
    public static function make(): Filter
    {
        return Tables\Filters\Filter::make('created_at')
            ->form([
                DatePicker::make('created_from')
                    ->label(\__('feedbackie-core::labels.filters.created_from')),
                DatePicker::make('created_until')
                    ->label(\__('feedbackie-core::labels.filters.created_until')),
            ])
            ->indicateUsing(function ($data) {
                $label = '';
                if (false === empty($data['created_from'])) {
                    $label .= \__('feedbackie-core::labels.filters.created_from') . ": " . $data['created_from'];
                }
                if (false === empty($label)) {
                    $label .= ", ";
                }
                if (false === empty($data['created_until'])) {
                    $label .= \__('feedbackie-core::labels.filters.created_until') . ": " . $data['created_until'];
                }

                if (empty($label) === false) {
                    return $label;
                }

                return null;
            })
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['created_from'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                    )
                    ->when(
                        $data['created_until'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                    );
            });
    }
}
