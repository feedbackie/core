<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\SiteResource\Actions;

use Filament\Actions\Action;

class CodeAction extends Action
{
    public static function make(?string $name = null): static
    {
        if (null === $name) {
            $name = \__('feedbackie-core::labels.actions.code');
        }

        $action = parent::make($name);
        $action->icon("heroicon-m-envelope");
        $action->modalContent(function ($record) {
            return view('feedbackie-core::sites.view-code', [
                'siteId' => $record->getKey(),
                'reportEnabled' => $record->report_enabled,
                'feedbackEnabled' => $record->feedback_enabled,
            ]);
        });
        $action->modalSubmitAction(false);

        return $action;
    }
}
