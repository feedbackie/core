<?php

declare(strict_types=1);

namespace Feedbackie\Core\Observers;

use Feedbackie\Core\Contracts\HasUserAndSiteScope;

class FillUserIdFromSite
{
    public function creating(HasUserAndSiteScope $model): void
    {
        if ($model->getUser() !== null) {
            return;
        }

        if ($model->getSite() === null) {
            return;
        }

        $model->setUser($model->getSite()->getUser());
    }
}
