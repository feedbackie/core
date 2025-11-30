<?php

namespace Feedbackie\Core\Filament\Traits;

use Feedbackie\Core\Http\Livewire\SiteSelector;

trait InteractsWithSiteSelector
{
    public abstract function dispatch(string $event);

    protected function getListeners(): array
    {
        return [
            SiteSelector::SITE_SELECTED_EVENT => "siteSelected",
            'siteUpdated' => '$refresh',
        ];
    }

    public function siteSelected(): void
    {
        $this->dispatch('siteUpdated');
    }
}
