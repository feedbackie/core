<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Feedbackie\Core\Filament\Resources\SiteResource\Pages\ListSites;
use Feedbackie\Core\Filament\Resources\SiteResource\Pages\CreateSite;
use Feedbackie\Core\Filament\Resources\SiteResource\Pages\EditSite;
use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Resources\SiteResource\Actions\CodeAction;
use Feedbackie\Core\Filament\Resources\SiteResource\Actions\OverviewAction;
use Feedbackie\Core\Filament\Resources\SiteResource\Pages;
use Feedbackie\Core\Models\Site;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SiteResource extends Resource
{
    protected static string $routePath = '/';

    protected static ?int $navigationSort = -3;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-globe-europe-africa';

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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                TextColumn::make("name")
                    ->label(\__('feedbackie-core::labels.resources.sites.name'))
                    ->action(OverviewAction::make()),
                TextColumn::make("domain")
                    ->label(\__('feedbackie-core::labels.resources.sites.domain'))
                    ->action(OverviewAction::make()),
                TextColumn::make("reports_count")
                    ->label(\__('feedbackie-core::labels.resources.sites.reports_count'))
                    ->action(OverviewAction::make()),
                TextColumn::make("feedbacks_count")
                    ->label(\__('feedbackie-core::labels.resources.sites.feedback_count'))
                    ->action(OverviewAction::make()),
                TextColumn::make("last_event_date")
                    ->label(\__('feedbackie-core::labels.resources.sites.last_event'))
                    ->action(OverviewAction::make()),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    OverviewAction::make()->color("default"),
                    CodeAction::make()->color("success"),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListSites::route('/'),
            'create' => CreateSite::route('/create'),
            'edit' => EditSite::route('/{record}/edit'),
        ];
    }
}
