<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Filters;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;

class CreatedAtFilter
{
    public static function make(): Filter
    {
        return Tables\Filters\Filter::make('created_at')
            ->form([
                Select::make('period')
                    ->label(\__('feedbackie-core::labels.filters.period'))
                    ->options([
                        'today' => \__('feedbackie-core::labels.filters.today'),
                        'yesterday' => \__('feedbackie-core::labels.filters.yesterday'),
                        'week' => \__('feedbackie-core::labels.filters.week'),
                        'last_month' => \__('feedbackie-core::labels.filters.last_month'),
                        'last_3_months' => \__('feedbackie-core::labels.filters.last_3_months'),
                        'custom' => \__('feedbackie-core::labels.filters.custom'),
                    ])
                    ->reactive()
                    ->placeholder(\__('feedbackie-core::labels.filters.select_period')),
                DatePicker::make('created_from')
                    ->label(\__('feedbackie-core::labels.filters.created_from'))
                    ->visible(fn($get) => $get('period') === 'custom'),
                DatePicker::make('created_until')
                    ->label(\__('feedbackie-core::labels.filters.created_until'))
                    ->visible(fn($get) => $get('period') === 'custom'),
            ])
            ->indicateUsing(function ($data) {
                if (empty($data['period'])) {
                    return null;
                }

                if ($data['period'] === 'custom') {
                    $label = '';
                    if (false === empty($data['created_from'])) {
                        $label .= \__('feedbackie-core::labels.filters.created_from') . ": " . $data['created_from'];
                    }
                    if (false === empty($label) && false === empty($data['created_until'])) {
                        $label .= ", ";
                    }
                    if (false === empty($data['created_until'])) {
                        $label .= \__('feedbackie-core::labels.filters.created_until') . ": " . $data['created_until'];
                    }

                    if (empty($label) === false) {
                        return $label;
                    }

                    return null;
                }

                $periodLabels = [
                    'today' => \__('feedbackie-core::labels.filters.today'),
                    'yesterday' => \__('feedbackie-core::labels.filters.yesterday'),
                    'week' => \__('feedbackie-core::labels.filters.week'),
                    'last_month' => \__('feedbackie-core::labels.filters.last_month'),
                    'last_3_months' => \__('feedbackie-core::labels.filters.last_3_months'),
                ];

                return $periodLabels[$data['period']] ?? null;
            })
            ->query(function (Builder $query, array $data): Builder {
                $period = $data['period'] ?? null;

                if (empty($period)) {
                    return $query;
                }

                if ($period === 'custom') {
                    return $query
                        ->when(
                            $data['created_from'] ?? null,
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'] ?? null,
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }

                $dates = self::getPeriodDates($period);

                if ($dates['from']) {
                    $query->whereDate('created_at', '>=', $dates['from']);
                }

                if ($dates['until']) {
                    $query->whereDate('created_at', '<=', $dates['until']);
                }

                return $query;
            });
    }

    private static function getPeriodDates(string $period): array
    {
        $now = Carbon::now();

        return match ($period) {
            'today' => [
                'from' => $now->copy()->startOfDay()->toDateString(),
                'until' => $now->copy()->endOfDay()->toDateString(),
            ],
            'yesterday' => [
                'from' => $now->copy()->subDay()->startOfDay()->toDateString(),
                'until' => $now->copy()->subDay()->endOfDay()->toDateString(),
            ],
            'week' => [
                'from' => $now->copy()->subDays(6)->startOfDay()->toDateString(),
                'until' => $now->copy()->endOfDay()->toDateString(),
            ],
            'last_month' => [
                'from' => $now->copy()->subMonth()->startOfMonth()->toDateString(),
                'until' => $now->copy()->subMonth()->endOfMonth()->toDateString(),
            ],
            'last_3_months' => [
                'from' => $now->copy()->subMonths(3)->startOfMonth()->toDateString(),
                'until' => $now->copy()->endOfMonth()->toDateString(),
            ],
            default => [
                'from' => null,
                'until' => null,
            ],
        };
    }
}
