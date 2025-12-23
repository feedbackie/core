<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\SiteResource\Pages;

use Filament\Actions\DeleteAction;
use Feedbackie\Core\Filament\Resources\SiteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSite extends EditRecord
{
    protected static string $resource = SiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
