<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\SiteResource\Actions;

use Feedbackie\Core\Filament\Pages\SiteOverviewDashboard;
use Feedbackie\Core\Services\SitesStorage;
use Filament\Tables\Actions\Action;

class OverviewAction extends Action
{
    public static function make(?string $name = null): static
    {
        if (null === $name) {
            $name = \__('feedbackie-core::labels.actions.overview');
        }

        $action = parent::make($name);
        $action->icon("heroicon-m-eye");
        $action->action(function ($record) {
            $siteStorage = app()->get(SitesStorage::class);
            $siteStorage->updateCurrentSiteId($record->getKey());
            return redirect()->route(SiteOverviewDashboard::getRouteName());
        });

        return $action;
    }

}
