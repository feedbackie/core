<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services;

use RuntimeException;
use Feedbackie\Core\Models\Site;
use Illuminate\Database\Eloquent\Builder;

class SitesStorage
{
    private ?string $currentSiteId = null;

    const SESSION_KEY = "site_id";

    public function __construct()
    {
        $siteId = session()->get(self::SESSION_KEY);

        if(null !== $siteId) {
            $this->currentSiteId = $siteId;
        }else{
            $this->currentSiteId = null;
        }
    }

    public function updateCurrentSiteId(string $siteId)
    {
        $this->currentSiteId = $siteId;

        session()->put(self::SESSION_KEY, $siteId);
    }

    public function count(): int
    {
        return Site::query()->count();
    }

    public function first(): Site
    {
        return Site::firstOr(function () {
            throw new RuntimeException("There are no sites!");
        });
    }

    public function has(?string $siteId): bool
    {
        if (empty($siteId)) {
            return false;
        }
        return Site::query()->where("id", $siteId)->count() > 0;
    }

    public function resolveCurrentSiteId(): ?string
    {
        $siteId = $this->currentSiteId;
        //Not selected
        if ($siteId === "") {
            return $siteId;
        }

        $count = $this->count();

        if (null === $siteId && $count > 0) {
            $site = $this->first();
            $this->updateCurrentSiteId($site->getKey());

            return $site->getKey();
        } elseif (false === $this->has($siteId) && $count > 0) {
            $site = $this->first();
            $this->updateCurrentSiteId($site->getKey());

            return $site->getKey();
        } elseif ($count > 0) {
            return $siteId;
        }

        return null;
    }

    public function applySiteScopeToQuery(Builder $builder): Builder
    {
        $siteId = $this->resolveCurrentSiteId();

        if (false === empty($siteId)) {
            $builder->where('site_id', $siteId);
        } else {
            //Select nothing
            $builder->whereRaw("FALSE");
        }

        return $builder;
    }
}
