<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\Reports\Widgets;

use Feedbackie\Core\Filament\Traits\InteractsWithSiteSelector;
use Feedbackie\Core\Models\Report;
use Feedbackie\Core\Traits\HasChartDateFilters;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class ReportsChart extends ChartWidget
{
    use HasChartDateFilters;
    use InteractsWithSiteSelector;

    protected array|int|string $columnSpan = 'full';

    public ?string $filter = 'month';
    protected ?string $pollingInterval = null;

    public function getHeading(): string|Htmlable|null
    {
        return \__('feedbackie-core::labels.resources.report_stats.record_plural_label');
    }

    protected function getData(): array
    {
        $items = $this->applyFilterToQuery(Report::query(), $this->filter)
            ->currentSite()
            ->selectRaw("COUNT (*) as reports_count")
            ->groupBy("date")
            ->orderBy('date')
            ->get();

        $total = [];
        $labels = [];

        foreach ($items as $item) {
            $total[] = $item["reports_count"];
            $labels[] = $item["date"];
        }

        return [
            'datasets' => [
                [
                    'label' =>  \__('feedbackie-core::labels.resources.report_stats.total'),
                    'data' => $total,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array|RawJs|null
    {
        return [];
    }
}
