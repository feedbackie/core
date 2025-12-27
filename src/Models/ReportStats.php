<?php

declare(strict_types=1);

namespace Feedbackie\Core\Models;

use Feedbackie\Core\Traits\HasCurrentSiteScope;
use Illuminate\Database\Eloquent\Model;

class ReportStats extends Model
{
    use HasCurrentSiteScope;

    public $table = "reports";

    public $incrementing = false;

    public $keyType = "string";

    public $primaryKey = "url";

    protected function newBaseQueryBuilder()
    {
        $builder = parent::newBaseQueryBuilder();

        $builder->selectRaw("url")
            ->selectRaw("count(*) as total")
            ->selectRaw("count(*) FILTER (WHERE LENGTH(comment) > 0) AS comments_count")
            ->groupBy("url");

        return $builder;
    }
}
