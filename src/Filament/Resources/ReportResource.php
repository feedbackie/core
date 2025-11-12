<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources;

use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Filament\Resources\ReportResource\Pages;
use Feedbackie\Core\Filament\Schemas\MetadataSchema;
use Feedbackie\Core\Filament\Filters\CreatedAtFilter;
use Feedbackie\Core\Filament\Filters\UrlFilter;
use Feedbackie\Core\Filament\Traits\HasLabelsWithoutTitleCase;
use Feedbackie\Core\Models\Feedback;
use Feedbackie\Core\Models\Report;
use Feedbackie\Core\Utils\Colors;
use Feedbackie\Core\Utils\Hash;
use Carbon\Carbon;
use Feedbackie\Core\Utils\Icons;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    use HasLabelsWithoutTitleCase;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Report')
                    ->label(\__('feedbackie-core::labels.resources.report.main_fieldset'))
                    ->schema([
                        Forms\Components\RichEditor::make("full_text")
                            ->label(\__('feedbackie-core::labels.resources.report.full_text'))
                            ->formatStateUsing(function ($state) {
                                $text = str_replace('[sel]', '<span style="color:red">', $state);
                                $text = str_replace('[/sel]', '</span>', $text);

                                return $text;
                            }),
                        Forms\Components\RichEditor::make("diff_text")
                            ->label(\__('feedbackie-core::labels.resources.report.diff_text')),
                        Forms\Components\TextInput::make("comment")
                            ->label(\__('feedbackie-core::labels.resources.report.comment')),
                        Forms\Components\TextInput::make("created_at")
                            ->label(\__('feedbackie-core::labels.general.created_at'))
                            ->formatStateUsing(function ($state) {
                                return (new Carbon($state))->format("Y-m-d H:i:s");
                            }),
                    ]),
                Forms\Components\Fieldset::make('Metadata')
                    ->label(\__('feedbackie-core::labels.metadata.metadata_fieldset'))
                    ->relationship('metadata')
                    ->schema(MetadataSchema::make()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
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
                Tables\Columns\TextColumn::make("url")
                    ->url(function (Report $report) {
                        return $report->url;
                    }, true)
                    ->label(\__('feedbackie-core::labels.resources.report.url'))
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make("full_text")
                    ->label(\__('feedbackie-core::labels.resources.report.full_text'))
                    ->wrap(true)
                    ->html(true)
                    ->formatStateUsing(function (string $state) {
                        $text = str_replace('[sel]', '<span style="color:red">', $state);
                        $text = str_replace('[/sel]', '</span>', $text);

                        return $text;
                    }),
                Tables\Columns\TextColumn::make("diff_text")
                    ->label(\__('feedbackie-core::labels.resources.report.diff_text'))
                    ->html(true)
                    ->wrap(true)
                    ->formatStateUsing(function (string $state) {
                        return $state;
                    }),
                Tables\Columns\TextColumn::make("comment")
                    ->label(\__('feedbackie-core::labels.resources.report.comment'))
                    ->wrap(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                CreatedAtFilter::make(),
                UrlFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->icon(null),
                    Tables\Actions\DeleteAction::make()
                        ->icon(null),
                    Tables\Actions\ForceDeleteAction::make()
                        ->icon(null),
                    Tables\Actions\RestoreAction::make()
                        ->icon(null),
                ])])
            ->bulkActions([])
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
            'index' => Pages\ListReports::route('/'),
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

    public static function canViewAny(): bool
    {
        return FeedbackieConfiguration::isRouteSiteDependent();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
