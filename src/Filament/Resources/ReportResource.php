<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Feedbackie\Core\Filament\Resources\ReportResource\Pages\ListReports;
use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Schemas\MetadataSchema;
use Feedbackie\Core\Filament\Filters\CreatedAtFilter;
use Feedbackie\Core\Filament\Filters\UrlFilter;
use Feedbackie\Core\Filament\Traits\HasLabelsWithoutTitleCase;
use Feedbackie\Core\Models\Report;
use Feedbackie\Core\Utils\Colors;
use Feedbackie\Core\Utils\Hash;
use Carbon\Carbon;
use Feedbackie\Core\Utils\Icons;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    use HasLabelsWithoutTitleCase;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getNavigationGroup(): ?string
    {
        return \__('feedbackie-core::labels.resources.report.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return \__('feedbackie-core::labels.resources.report.navigation_label');
    }

    public static function getLabel(): string
    {
        return \__('feedbackie-core::labels.resources.report.record_label');
    }

    public static function getPluralLabel(): string
    {
        return \__('feedbackie-core::labels.resources.report.record_plural_label');
    }

    public static function getModel(): string
    {
        return FeedbackieConfiguration::getReportModelClass();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Report')
                    ->label(\__('feedbackie-core::labels.resources.report.main_fieldset'))
                    ->schema([
                        RichEditor::make("full_text")
                            ->label(\__('feedbackie-core::labels.resources.report.full_text'))
                            ->formatStateUsing(function ($state) {
                                $text = str_replace('[sel]', '<span style="color:red">', $state);
                                $text = str_replace('[/sel]', '</span>', $text);

                                return $text;
                            }),
                        RichEditor::make("diff_text")
                            ->label(\__('feedbackie-core::labels.resources.report.diff_text')),
                        Textarea::make("comment")
                            ->label(\__('feedbackie-core::labels.resources.report.comment')),
                        TextInput::make("created_at")
                            ->label(\__('feedbackie-core::labels.general.created_at'))
                            ->formatStateUsing(function ($state) {
                                return (new Carbon($state))->format("Y-m-d H:i:s");
                            }),
                    ]),
                Fieldset::make('Metadata')
                    ->label(\__('feedbackie-core::labels.metadata.metadata_fieldset'))
                    ->relationship('metadata')
                    ->schema(MetadataSchema::make()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")
                    ->label('#')
                    ->formatStateUsing(function (Report $record) {
                        $icons = '';

                        if (null !== $record->metadata?->country_code) {
                            $icons = $icons . ' ' . Icons::getCountryFlagByCode($record->metadata->country_code);
                        }

                        if (null !== $record->comment) {
                            $icons .= ' c';
                        }

                        if (empty(trim($icons))) {
                            $icons = '-';
                        }

                        return $icons;
                    })
                    ->icon('heroicon-o-user-circle')
                    ->iconColor(function (Report $record) {
                        return Colors::getColors()[Hash::md5ToNumber($record?->metadata?->getHashAttribute())];
                    })
                ,
                TextColumn::make("url")
                    ->url(function (Report $report) {
                        return $report->url;
                    }, true)
                    ->label(\__('feedbackie-core::labels.resources.report.url'))
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                TextColumn::make("full_text")
                    ->label(\__('feedbackie-core::labels.resources.report.full_text'))
                    ->wrap(true)
                    ->html(true)
                    ->formatStateUsing(function (string $state) {
                        $text = str_replace('[sel]', '<span style="color:red">', $state);
                        $text = str_replace('[/sel]', '</span>', $text);

                        return $text;
                    }),
                TextColumn::make("diff_text")
                    ->label(\__('feedbackie-core::labels.resources.report.diff_text'))
                    ->html(true)
                    ->wrap(true)
                    ->formatStateUsing(function (string $state) {
                        return $state;
                    }),
                TextColumn::make("comment")
                    ->label(\__('feedbackie-core::labels.resources.report.comment'))
                    ->wrap(),
            ])
            ->filters([
                TrashedFilter::make(),
                CreatedAtFilter::make(),
                UrlFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->icon(null),
                    DeleteAction::make()
                        ->icon(null),
                    ForceDeleteAction::make()
                        ->icon(null),
                    RestoreAction::make()
                        ->icon(null),
                ])])
            ->toolbarActions([])
            ->defaultSort("created_at", 'desc');
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
            'index' => ListReports::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        if (FeedbackieConfiguration::isRouteSiteDependent()) {
            return (string)static::getModel()::query()->currentSite()->count();
        } else {
            return "";
        }
    }

    public static function getViewAnyAuthorizationResponse(): Response
    {
        if (FeedbackieConfiguration::isRouteSiteDependent()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
