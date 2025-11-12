<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Widgets;

use Feedbackie\Core\Traits\HasChartDateFilters;
use Feedbackie\Core\Models\Feedback;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class FeedbackChart extends ChartWidget
{
    use HasChartDateFilters;

    protected array|int|string $columnSpan = 'full';

    public ?string $filter = 'month';

    public function getHeading(): string
    {
       return \__('feedbackie-core::labels.resources.feedback_stats.feedback_answers');
    }

    protected function getData(): array
    {
        $items = $this->applyFilterToQuery(Feedback::query(), $this->filter)
            ->selectRaw("COUNT (*) as answers_count")
            ->selectRaw("count(*) FILTER (WHERE answer = 'yes') AS yes_count")
            ->selectRaw("count(*) FILTER (WHERE answer = 'no') AS no_count")
            ->groupBy("date")
            ->orderBy('date')
            ->currentSite()
            ->get();

        $total = [];
        $yes = [];
        $no = [];
        $labels = [];

        foreach ($items as $item) {
            $total[] = $item["answers_count"];
            $yes[] = $item["yes_count"];
            $no[] = $item["no_count"];
            $labels[] = $item["date"];
        }

        return [
            'datasets' => [
                [
                    'label' => \__('feedbackie-core::labels.resources.feedback_stats.total'),
                    'data' => $total,
                    'fill' => true,
                    'backgroundColor' => 'rgba(251, 191, 36, 0.1)',
                    'borderColor' => 'rgb(251, 191, 36)',
                ],
                [
                    'label' => \__('feedbackie-core::labels.resources.feedback_stats.yes_count'),
                    'data' => $yes,
                    'fill' => true,
                    'backgroundColor' => 'rgba(74, 222, 128, 0.1)',
                    'borderColor' => 'rgb(74, 222, 128)',
                ],
                [
                    'label' => \__('feedbackie-core::labels.resources.feedback_stats.no_count'),
                    'data' => $no,
                    'fill' => true,
                    'backgroundColor' => 'rgba(248, 113, 113, 0.1)',
                    'borderColor' => 'rgb(248, 113, 113)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array|RawJs|null
    {
        return [
            "lineTension" => 0.2,
            "radius" => 6,
        ];
    }


}
