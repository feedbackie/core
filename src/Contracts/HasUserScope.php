<?php

declare(strict_types=1);

namespace Feedbackie\Core\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface HasUserScope
{
    public function getUser(): ?UserContract;

    public function setUser(UserContract $user): void;
}
