<?php

declare(strict_types=1);

namespace Feedbackie\Core\Contracts;

use Feedbackie\Core\Models\Site;

interface HasUserAndSiteScope extends HasUserScope
{
    public function getSite(): ?Site;
}
