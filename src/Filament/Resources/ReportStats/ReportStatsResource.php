<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\ReportStats;

use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Resources\ReportStats\Pages\ListReportStats;
use Feedbackie\Core\Filament\Traits\HasLabelsWithoutTitleCase;
use Feedbackie\Core\Models\ReportStats;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;

class ReportStatsResource extends Resource
{
    use HasLabelsWithoutTitleCase;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-pie';

    public static function getNavigationGroup(): ?string
    {
        return \__('feedbackie-core::labels.resources.report_stats.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return \__('feedbackie-core::labels.resources.report_stats.navigation_label');
    }

    public static function getLabel(): string
    {
        return \__('feedbackie-core::labels.resources.report_stats.record_label');
    }

    public static function getPluralLabel(): string
    {
        return \__('feedbackie-core::labels.resources.report_stats.record_plural_label');
    }

    public static function getModel(): string
    {
        return ReportStats::class;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("url")
                    ->label(__('feedbackie-core::labels.resources.report_stats.url'))
                    ->url(function ($state) {
                        return $state;
                    })
                    ->limit(50)
                    ->searchable(),
                TextColumn::make("total")
                    ->label(__('feedbackie-core::labels.resources.report_stats.total')),
                TextColumn::make("comments_count")
                    ->label(__('feedbackie-core::labels.resources.report_stats.has_comment_count')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
            ])
            ->toolbarActions([
            ])
            ->defaultSort("total", "desc");
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReportStats::route('/'),
        ];
    }

    public static function getViewAnyAuthorizationResponse(): Response
    {
        if (FeedbackieConfiguration::isRouteSiteDependent()) {
            return Response::allow();
        }

        return Response::deny();
    }
}
