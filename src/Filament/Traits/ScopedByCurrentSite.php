<?php

declare(strict_types=1);

namespace Feedbackie\Core\Filament\Traits;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

trait ScopedByCurrentSite
{
    public function table(Table $table): Table
    {
        $table->modifyQueryUsing(function (Builder $query) {
            $query->currentSite();
        });
        return parent::table($table);
    }
}
