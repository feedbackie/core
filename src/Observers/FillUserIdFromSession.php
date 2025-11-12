<?php

declare(strict_types=1);

namespace Feedbackie\Core\Observers;

use Feedbackie\Core\Contracts\HasUserScope;
use Feedbackie\Core\Contracts\UserContract;

class FillUserIdFromSession
{
    public function creating(HasUserScope $model): void
    {
        $user = auth()->user();

        if (false === $user instanceof UserContract) {
            return;
        }

        $model->setUser($user);
    }
}
