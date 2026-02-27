<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\Sites\Actions;

use Feedbackie\Core\Models\Site;
use Feedbackie\Core\Services\Builders\SiteCodeBuilder;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class CodeAction extends Action
{
    public static function make(?string $name = null): static
    {
        if (null === $name) {
            $name = \__('feedbackie-core::labels.actions.code');
        }

        $action = parent::make($name);
        $action->icon("heroicon-m-envelope");

        $updateCode = function (Set $set, Get $get, Site $record): void {
            $set('code', static::buildCode(
                $record,
                $get('report_anchor'),
                $get('feedback_anchor'),
            ));
        };

        $action->schema([
            TextInput::make('report_anchor')
                ->placeholder(__('feedbackie-core::labels.code_viewer.report_anchor_placeholder'))
                ->live()
                ->afterStateUpdated($updateCode)
                ->label(__('feedbackie-core::labels.code_viewer.report_anchor_label')),
            TextInput::make('feedback_anchor')
                ->placeholder(__('feedbackie-core::labels.code_viewer.feedback_anchor_placeholder'))
                ->live()
                ->afterStateUpdated($updateCode)
                ->label(__('feedbackie-core::labels.code_viewer.feedback_anchor_label')),
            Textarea::make('code')
                ->label(__('feedbackie-core::labels.code_viewer.generated_code_label'))
                ->afterStateHydrated($updateCode)
                ->disabled()
                ->dehydrated(false)
                ->rows(10),
        ]);
        $action->modalSubmitAction(false);

        return $action;
    }

    private static function buildCode(Site $record, ?string $reportAnchor, ?string $feedbackAnchor): string
    {
        $builder = (new SiteCodeBuilder($record->getKey()))
            ->reportEnabled($record->report_enabled)
            ->feedbackEnabled($record->feedback_enabled);

        if ($record->report_enabled && $reportAnchor !== null) {
            $builder->reportAnchorSelector($reportAnchor);
        }

        if ($record->feedback_enabled && $feedbackAnchor !== null) {
            $builder->feedbackAnchorSelector($feedbackAnchor);
        }

        return $builder->build();
    }
}
