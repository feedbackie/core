<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Pages;

use Feedbackie\Core\Filament\Traits\InteractsWithSiteSelector;
use Feedbackie\Core\Filament\Traits\ScopedByCurrentSite;
use Filament\Resources\Pages\ListRecords;

abstract class SiteDependentListRecords extends ListRecords
{
    use ScopedByCurrentSite;
    use InteractsWithSiteSelector {
        InteractsWithSiteSelector::siteSelected as protected traitSiteSelected;
    }

    public function siteSelected(): void
    {
        $this->traitSiteSelected();

        $this->dispatch('refresh-sidebar');
    }
}
