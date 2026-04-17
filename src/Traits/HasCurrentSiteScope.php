<?php

declare(strict_types=1);

namespace Feedbackie\Core\Traits;

use Feedbackie\Core\Services\SitesStorage;
use Illuminate\Database\Eloquent\Builder;

trait HasCurrentSiteScope
{
    protected function scopeCurrentSite(Builder $query): Builder
    {
        $service = app()->get(SitesStorage::class);

        return $service->applySiteScopeToQuery($query);
    }
}
