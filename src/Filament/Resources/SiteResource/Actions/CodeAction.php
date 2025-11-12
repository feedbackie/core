<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\SiteResource\Actions;

use Feedbackie\Core\Services\Builders\SiteCodeBuilder;
use Filament\Tables\Actions\Action;

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
            $code = (new SiteCodeBuilder($record->getKey()))
                ->reportEnabled($record->report_enabled)
                ->feedbackEnabled($record->feedback_enabled)
                ->reportAnchorSelector("REPLACE")
                ->feedbackAnchorSelector("REPLACE")
                ->build();

            return view('feedbackie-core::sites.view-code', [
                'code' => $code,
            ]);
        });
        $action->modalSubmitAction(false);

        return $action;
    }
}
