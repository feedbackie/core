<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources;

use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Resources\SiteResource\Actions\CodeAction;
use Feedbackie\Core\Filament\Resources\SiteResource\Actions\OverviewAction;
use Feedbackie\Core\Filament\Resources\SiteResource\Pages;
use Feedbackie\Core\Models\Site;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SiteResource extends Resource
{
    protected static string $routePath = '/';

    protected static ?int $navigationSort = -3;

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';

    public static function getModel(): string
    {
        return FeedbackieConfiguration::getSiteModelClass();
    }

    public static function getNavigationLabel(): string
    {
        return \__('feedbackie-core::labels.resources.sites.navigation_label');
    }

    public static function getLabel(): string
    {
        return \__('feedbackie-core::labels.resources.sites.record_label');
    }

    public static function getPluralLabel(): string
    {
        return \__('feedbackie-core::labels.resources.sites.record_plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("name")
                    ->label(\__('feedbackie-core::labels.resources.sites.name'))
                    ->required(),
                TextInput::make("domain")
                    ->label(\__('feedbackie-core::labels.resources.sites.domain'))
                    ->required(),
                TextInput::make('id')
                    ->label(\__('feedbackie-core::labels.resources.sites.id'))
                    ->hiddenOn('create')
                    ->disabled(),
                Fieldset::make("Settings")
                    ->label(\__('feedbackie-core::labels.resources.sites.settings'))
                    ->schema([
                        Toggle::make("report_enabled")
                            ->label(\__('feedbackie-core::labels.resources.sites.reports_enabled'))
                            ->default(true),
                        Toggle::make("feedback_enabled")
                            ->label(\__('feedbackie-core::labels.resources.sites.feedback_enabled'))
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(OverviewAction::class)
            ->modifyQueryUsing(function (Builder $query) {
                $query
                    ->withCount("reports")
                    ->withCount("feedbacks");
            })
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->label(\__('feedbackie-core::labels.resources.sites.name'))
                    ->action(OverviewAction::make()),
                Tables\Columns\TextColumn::make("domain")
                    ->label(\__('feedbackie-core::labels.resources.sites.domain'))
                    ->action(OverviewAction::make()),
                Tables\Columns\TextColumn::make("reports_count")
                    ->label(\__('feedbackie-core::labels.resources.sites.reports_count'))
                    ->action(OverviewAction::make()),
                Tables\Columns\TextColumn::make("feedbacks_count")
                    ->label(\__('feedbackie-core::labels.resources.sites.feedback_count'))
                    ->action(OverviewAction::make()),
                Tables\Columns\TextColumn::make("last_event_date")
                    ->label(\__('feedbackie-core::labels.resources.sites.last_event'))
                    ->action(OverviewAction::make()),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    OverviewAction::make()->color("default"),
                    CodeAction::make()->color("success"),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSite::route('/create'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
        ];
    }
}
