<?php

declare(strict_types=1);

namespace Feedbackie\Core\Traits;

use Feedbackie\Core\Contracts\UserContract;
use Feedbackie\Core\Models\Site;
use Illuminate\Contracts\Auth\Authenticatable;

trait InteractsWithUserAndSite
{
    public abstract function setAttribute($key, $value);

    public abstract function getRelation(string $key);

    public abstract function relationLoaded(string $key);

    public function setUser(UserContract $user): void
    {
        $this->setAttribute('user_id', $user->getKey());
    }

    public function getSite(): ?Site
    {
        if (false === $this->relationLoaded('site')) {
            return null;
        }

        return $this->getRelation('site');
    }

    public function getUser(): ?UserContract
    {
        if (false === $this->relationLoaded('user')) {
            return null;
        }

        return $this->getRelation('user');
    }
}
