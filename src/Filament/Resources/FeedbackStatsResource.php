<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Pages\ListFeedbackStats;
use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Resources\FeedbackStatsResource\Pages;
use Feedbackie\Core\Filament\Traits\HasLabelsWithoutTitleCase;
use Feedbackie\Core\Models\FeedbackStats;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;

class FeedbackStatsResource extends Resource
{
    use HasLabelsWithoutTitleCase;

    protected static ?string $model = FeedbackStats::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar-square';

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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                TextColumn::make("url")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.url'))
                    ->url(function ($state) {
                        return $state;
                    })
                    ->limit(60)
                    ->searchable(),
                TextColumn::make("total")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.total'))
                    ->sortable(),
                TextColumn::make("yes_count")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.yes_count'))
                    ->sortable(),
                TextColumn::make("no_count")
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.no_count'))
                    ->sortable(),
                TextColumn::make("avg_score")->sortable()
                    ->label(\__('feedbackie-core::labels.resources.feedback_stats.avg_score'))
                    ->numeric(2),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => ListFeedbackStats::route('/'),
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
