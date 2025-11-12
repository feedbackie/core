<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Schemas;

use Feedbackie\Core\Models\Metadata;
use Feedbackie\Core\Utils\Date;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class MetadataSchema
{
    public static function make(): array
    {
        return [
            TextInput::make("ip")
                ->label(\__('feedbackie-core::labels.metadata.ip')),
            TextInput::make("country")
                ->label(\__('feedbackie-core::labels.metadata.country')),
            TextInput::make("device")
                ->label(\__('feedbackie-core::labels.metadata.device')),
            TextInput::make("os")->label("OS")
                ->label(\__('feedbackie-core::labels.metadata.os')),
            TextInput::make("browser")
                ->label(\__('feedbackie-core::labels.metadata.browser')),
            TextInput::make("language")
                ->label(\__('feedbackie-core::labels.metadata.language')),
            Textarea::make("user_agent")->rows(5)
                ->label(\__('feedbackie-core::labels.metadata.user_agent')),
            TextInput::make("ls")
                ->label(\__('feedbackie-core::labels.metadata.duration'))
                ->formatStateUsing(function (?Metadata $record) {
                    if ($record === null) {
                        return "";
                    }
                    return Date::formatSeconds($record->ts - $record->ls);
                }),
        ];
    }
}
