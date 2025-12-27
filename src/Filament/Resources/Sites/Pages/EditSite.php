<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Resources\Sites\Pages;

use Feedbackie\Core\Filament\Resources\Sites\SiteResource;
use Filament\Actions\DeleteAction;
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
