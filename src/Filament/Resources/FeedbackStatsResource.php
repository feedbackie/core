<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources;

use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Pages;
use Feedbackie\Core\Filament\Traits\HasLabelsWithoutTitleCase;
use Feedbackie\Core\Models\FeedbackStats;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FeedbackStatsResource extends Resource
{
    use HasLabelsWithoutTitleCase;

    protected static ?string $model = FeedbackStats::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    public static function getNavigationGroup(): ?string
    {
        return \__('feedbackie-core::labels.resources.feedback_stats.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return \__('feedbackie-core::labels.resources.feedback_stats.navigation_label');
    }

    public static function getLabel(): string
    {
        return \__('feedbackie-core::labels.resources.feedback_stats.record_label');
    }

    public static function getPluralLabel(): string
    {
        return \__('feedbackie-core::labels.resources.feedback_stats.record_plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("total")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.total')),
                TextInput::make("yes_count")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.yes_count')),
                TextInput::make("no_count")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.no_count')),
                TextInput::make("avg_score")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.avg_score'))
                    ->formatStateUsing(function ($state) {
                        return round(floatval($state), 2);
                    }),
                Select::make("comments")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.comments'))
                    ->multiple(),
                Select::make("options")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.options'))
                    ->multiple(),
                Select::make("language_scores")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.language_scores'))
                    ->multiple(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("url")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.url'))
                    ->url(function ($state) {
                        return $state;
                    })
                    ->limit(60)
                    ->searchable(),
                Tables\Columns\TextColumn::make("total")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.total'))
                    ->sortable(),
                Tables\Columns\TextColumn::make("yes_count")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.yes_count'))
                    ->sortable(),
                Tables\Columns\TextColumn::make("no_count")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.no_count'))
                    ->sortable(),
                Tables\Columns\TextColumn::make("avg_score")->sortable()
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.avg_score'))
                    ->numeric(2),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListFeedbackStats::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return FeedbackieConfiguration::isRouteSiteDependent();
    }
}
