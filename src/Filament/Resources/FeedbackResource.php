<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Feedbackie\Core\Filament\Resources\FeedbackResource\Pages\ListFeedbacks;
use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Enums\FeedbackOptions;
use Feedbackie\Core\Enums\LanguageScores;
use Feedbackie\Core\Filament\Schemas\MetadataSchema;
use Feedbackie\Core\Filament\Filters\AnswerFilter;
use Feedbackie\Core\Filament\Filters\CreatedAtFilter;
use Feedbackie\Core\Filament\Filters\HasCommentFilter;
use Feedbackie\Core\Filament\Filters\HasEmailFilter;
use Feedbackie\Core\Filament\Filters\HasOptionsFilter;
use Feedbackie\Core\Filament\Filters\OptionsFilter;
use Feedbackie\Core\Filament\Traits\HasLabelsWithoutTitleCase;
use Feedbackie\Core\Models\Feedback;
use Feedbackie\Core\Utils\Colors;
use Feedbackie\Core\Utils\Date;
use Feedbackie\Core\Utils\Hash;
use Carbon\Carbon;
use Feedbackie\Core\Utils\Icons;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\HtmlString;

class FeedbackResource extends Resource
{
    use HasLabelsWithoutTitleCase;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function getNavigationGroup(): ?string
    {
        return \__('feedbackie-core::labels.resources.feedback.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return \__('feedbackie-core::labels.resources.feedback.navigation_label');
    }

    public static function getLabel(): string
    {
        return \__('feedbackie-core::labels.resources.feedback.record_label');
    }

    public static function getPluralLabel(): string
    {
        return \__('feedbackie-core::labels.resources.feedback.record_plural_label');
    }

    public static function getModel(): string
    {
        return FeedbackieConfiguration::getFeedbackModelClass();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Feedback')
                    ->label(\__('feedbackie-core::labels.resources.feedback.main_fieldset'))
                    ->schema([
                        TextInput::make("url")
                            ->label(\__('feedbackie-core::labels.resources.feedback.url')),
                        TextInput::make("answer")
                            ->formatStateUsing(function ($state) {
                                if ($state === 'yes') {
                                    return \__('feedbackie-core::labels.general.yes');
                                } elseif ($state === 'no') {
                                    return \__('feedbackie-core::labels.general.no');
                                } else {
                                    return $state;
                                }
                            })
                            ->label(\__('feedbackie-core::labels.resources.feedback.answer')),
                        Select::make("options")
                            ->label(\__('feedbackie-core::labels.resources.feedback.options'))
                            ->formatStateUsing(function ($state) {
                                if ($state == null) {
                                    return "";
                                }
                                $labels = [];
                                foreach ($state as $item) {
                                    $labels[] = FeedbackOptions::from($item)->label();
                                }
                                return $labels;
                            })
                            ->multiple(),
                        TextInput::make("language_score")
                            ->label(\__('feedbackie-core::labels.resources.feedback.language_score'))
                            ->formatStateUsing(function ($state) {
                                if (null !== $state) {
                                    return LanguageScores::from($state)->label();
                                } else {
                                    return "";
                                }
                            }),
                        Textarea::make("comment")
                            ->label(\__('feedbackie-core::labels.resources.feedback.comment')),
                        Textarea::make("email")
                            ->label(\__('feedbackie-core::labels.resources.feedback.email')),
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
                    ->formatStateUsing(function (Feedback $record) {
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
                    ->iconColor(function (Feedback $record) {
                        return Colors::getColors()[Hash::md5ToNumber($record?->metadata?->getHashAttribute())];
                    })
                ,
                TextColumn::make("url")
                    ->label(\__('feedbackie-core::labels.resources.feedback.url'))
                    ->url(function ($state) {
                        return $state;
                    })
                    ->wrap()
                    ->limit(60)
                    ->searchable(),
                TextColumn::make("answer")
                    ->label(\__('feedbackie-core::labels.resources.feedback.answer'))
                    ->badge()->colors(["primary", "success" => "yes", "danger" => "no"]),
                TextColumn::make("options")
                    ->label(\__('feedbackie-core::labels.resources.feedback.options'))
                    ->badge()
                    ->wrap()
                    ->formatStateUsing(function ($state) {
                        return FeedbackOptions::from($state)->label();
                    }),
                TextColumn::make("metadata.ls")
                    ->label(\__('feedbackie-core::labels.metadata.duration'))
                    ->toggleable(true, false)
                    ->formatStateUsing(function (?Feedback $record) {
                        if ($record === null) {
                            return "";
                        }

                        $duration = Date::formatSeconds($record->metadata->ts - $record->metadata->ls);

                        return $duration;
                    }),
                TextColumn::make("language_score")
                    ->label(\__('feedbackie-core::labels.resources.feedback.language_score'))
                    ->sortable()
                    ->tooltip(function ($state) {
                        if (null !== $state) {
                            return LanguageScores::from($state)->label();
                        } else {
                            return "";
                        }
                    })
                    ->toggleable(true, true),
                TextColumn::make("metadata.country")
                    ->label(\__('feedbackie-core::labels.metadata.country'))
                    ->toggleable(true, true),
                TextColumn::make("metadata.ip")
                    ->label(\__('feedbackie-core::labels.metadata.ip'))
                    ->toggleable(true, true),
                TextColumn::make("metadata.browser")
                    ->label(\__('feedbackie-core::labels.metadata.browser'))
                    ->toggleable(true, true),
                TextColumn::make("metadata.device")
                    ->label(\__('feedbackie-core::labels.metadata.device'))
                    ->toggleable(true, true),
                TextColumn::make("metadata.os")
                    ->label(\__('feedbackie-core::labels.metadata.os'))
                    ->toggleable(true, true),
                TextColumn::make("created_at")
                    ->label(\__('feedbackie-core::labels.general.created_at'))
                    ->toggleable(true, false),
                TextColumn::make("comment")
                    ->label(\__('feedbackie-core::labels.resources.feedback.comment'))
                    ->wrap()
                    ->toggleable(true, true),
            ])
            ->filters([
                AnswerFilter::make(),
                OptionsFilter::make(),
                CreatedAtFilter::make(),
                HasOptionsFilter::make(),
                HasCommentFilter::make(),
                HasEmailFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(\__('feedbackie-core::labels.actions.delete'))
            ])
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
            'index' => ListFeedbacks::route('/'),
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
}
