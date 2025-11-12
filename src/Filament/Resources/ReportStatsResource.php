<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources;

use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Resources\ReportStatsResource\Pages;
use Feedbackie\Core\Filament\Traits\HasLabelsWithoutTitleCase;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class ReportStatsResource extends Resource
{
    use HasLabelsWithoutTitleCase;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

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
        return FeedbackieConfiguration::getReportModelClass();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("url")
                    ->label(__('feedbackie-core::labels.resources.report_stats.url'))
                    ->url(function ($state) {
                        return $state;
                    })
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make("total")
                    ->label(__('feedbackie-core::labels.resources.report_stats.total')),
                Tables\Columns\TextColumn::make("comments_count")
                    ->label(__('feedbackie-core::labels.resources.report_stats.has_comment_count')),
            ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
            ])
            ->defaultSort("total");
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
            'index' => Pages\ListReportStats::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return FeedbackieConfiguration::isRouteSiteDependent();
    }
}
