<?php

declare(strict_types=1);

namespace Feedbackie\Core\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait HasChartDateFilters
{
    protected function getFilters(): ?array
    {
        return [
            'today' => \__('feedbackie-core::labels.periods.today'),
            'yesterday' => \__('feedbackie-core::labels.periods.yesterday'),
            'week' => \__('feedbackie-core::labels.periods.current_week'),
            'prev_week' => \__('feedbackie-core::labels.periods.previous_week'),
            'month' => \__('feedbackie-core::labels.periods.current_month'),
            'prev_month' => \__('feedbackie-core::labels.periods.previous_month'),
            'year' => \__('feedbackie-core::labels.periods.current_year'),
            'prev_year' => \__('feedbackie-core::labels.periods.previous_year'),
        ];
    }

    protected function applyFilterToQuery(Builder $query, $filter): Builder
    {
        if ($filter === "today") {
            $dateAgg = "date_part('hour', created_at)";
            $startDate = $this->getCurrentDate()->startOfDay();
            $endDate = $this->getCurrentDate()->endOfDay();
        } elseif ($filter === "yesterday") {
            $dateAgg = "date_part('hour', created_at)";
            $startDate = $this->getCurrentDate()->subDay()->startOfDay();
            $endDate = $this->getCurrentDate()->subDay()->endOfDay();
        } elseif ($filter === "week") {
            $dateAgg = "DATE(created_at)";
            $startDate = $this->getCurrentDate()->startOfWeek();
            $endDate = $this->getCurrentDate()->endOfWeek();
        } elseif ($filter === "prev_week") {
            $dateAgg = "DATE(created_at)";
            $startDate = $this->getCurrentDate()->subWeek()->startOfWeek();
            $endDate = $this->getCurrentDate()->subWeek()->endOfWeek();
        } elseif ($filter === "month") {
            $dateAgg = "DATE(created_at)";
            $startDate = $this->getCurrentDate()->startOfMonth();
            $endDate = $this->getCurrentDate()->endOfMonth();
        } elseif ($filter === "prev_month") {
            $dateAgg = "DATE(created_at)";
            $startDate = $this->getCurrentDate()->subMonth()->startOfMonth();
            $endDate = $this->getCurrentDate()->subMonth()->endOfMonth();
        } elseif ($filter === "year") {
            $dateAgg = "date_part('month', created_at)";
            $startDate = $this->getCurrentDate()->startOfYear();
            $endDate = $this->getCurrentDate()->endOfYear();
        } elseif ($filter === "prev_year") {
            $dateAgg = "date_part('month', created_at)";
            $startDate = $this->getCurrentDate()->subYear()->startOfYear();
            $endDate = $this->getCurrentDate()->subYear()->endOfYear();
        } else {
            throw new \RuntimeException("Unknown filter");
        }

        $query->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw("$dateAgg as date");

        return $query;
    }

    protected function getCurrentDate(): Carbon
    {
        return now();
    }
}
