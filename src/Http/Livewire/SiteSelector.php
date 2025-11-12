<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Livewire;

use Feedbackie\Core\Models\Site;
use Feedbackie\Core\Services\SitesStorage;
use Illuminate\View\ComponentAttributeBag;
use Livewire\Component;

class SiteSelector extends Component
{
    public ?string $siteId = null;

    const COMPONENT_NAME = 'feedbackie-core::site-selector';
    const SITE_SELECTED_EVENT = 'siteSelected';

    public function mount()
    {
        $this->siteId = app(SitesStorage::class)->resolveCurrentSiteId();
    }

    public function render()
    {
        return view('feedbackie-core::components.site-selector', [
            'placeholder' => $this->getPlaceholder(),
            'sites' => $this->getSites(),
        ]);
    }

    public function getPlaceholder(): string
    {
        return "Not selected";
    }

    public function getSites(): array
    {
        return Site::query()->get()
            ->map(function (Site $site) {
                $site->name = $site->name . ' (' . $site->domain . ')';

                return $site;
            })
            ->pluck("name", "id")
            ->toArray();
    }

    public function getExtraAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag();
    }

    public function siteSelected()
    {
        $this->dispatch(self::SITE_SELECTED_EVENT);

        app(SitesStorage::class)->updateCurrentSiteId($this->siteId);
    }
}
