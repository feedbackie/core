<?php

declare(strict_types=1);

namespace Feedbackie\Core\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Feedbackie\Core\Casts\AsFeedbackOptionsDistribution;
use Feedbackie\Core\Casts\AsLanguageScoreDistribution;
use Feedbackie\Core\Traits\HasCurrentSiteScope;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property string $id
 * @property string|null $site_id
 * @property string $answer
 * @property string|null $comment
 * @property $options
 * @property string $url
 * @property string $url_hash
 * @property string|null $hash
 * @property int|null $language_score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property string|null $email
 * @property $language_scores
 * @method static Builder<static>|FeedbackStats newModelQuery()
 * @method static Builder<static>|FeedbackStats newQuery()
 * @method static Builder<static>|FeedbackStats query()
 * @method static Builder<static>|FeedbackStats whereAnswer($value)
 * @method static Builder<static>|FeedbackStats whereComment($value)
 * @method static Builder<static>|FeedbackStats whereCreatedAt($value)
 * @method static Builder<static>|FeedbackStats whereEmail($value)
 * @method static Builder<static>|FeedbackStats whereHash($value)
 * @method static Builder<static>|FeedbackStats whereId($value)
 * @method static Builder<static>|FeedbackStats whereLanguageScore($value)
 * @method static Builder<static>|FeedbackStats whereOptions($value)
 * @method static Builder<static>|FeedbackStats whereSiteId($value)
 * @method static Builder<static>|FeedbackStats whereUpdatedAt($value)
 * @method static Builder<static>|FeedbackStats whereUrl($value)
 * @method static Builder<static>|FeedbackStats whereUrlHash($value)
 * @method static Builder<static>|FeedbackStats whereUserId($value)
 * @mixin \Eloquent
 */
class FeedbackStats extends Model
{
    use HasCurrentSiteScope;

    public $table = "feedback";

    public $incrementing = false;

    public $keyType = "string";

    public $primaryKey = "url";

    public $casts = [
        "comments" => AsArrayObject::class,
        "options" => AsFeedbackOptionsDistribution::class,
        "language_scores" => AsLanguageScoreDistribution::class,
    ];

    protected function newBaseQueryBuilder()
    {
        $builder = parent::newBaseQueryBuilder();

        $driver = DB::connection()->getDriverName();

        if ($driver === 'pgsql') {
            $builder
                ->selectRaw("url")
                ->selectRaw("count(*) as total")
                ->selectRaw("count(*) FILTER (WHERE answer = 'yes') AS yes_count")
                ->selectRaw("count(*) FILTER (WHERE answer = 'no') AS no_count")
                ->selectRaw("json_agg(comment) FILTER (WHERE comment IS NOT NULL) AS comments")
                ->selectRaw("json_agg(options) AS options")
                ->selectRaw("json_agg(language_score) AS language_scores")
                ->selectRaw("avg(language_score) FILTER (WHERE language_score IS NOT NULL) AS avg_score")
                ->groupBy("url");
        } elseif ($driver === 'sqlite') {
            $builder
                ->selectRaw("url")
                ->selectRaw("count(*) as total")
                ->selectRaw("count(*) FILTER (WHERE answer = 'yes') AS yes_count")
                ->selectRaw("count(*) FILTER (WHERE answer = 'no') AS no_count")
                ->selectRaw("json_group_array(comment) FILTER (WHERE comment IS NOT NULL) AS comments")
                ->selectRaw("json_group_array(options) AS options")
                ->selectRaw("json_group_array(language_score) AS language_scores")
                ->selectRaw("avg(language_score) FILTER (WHERE language_score IS NOT NULL) AS avg_score")
                ->groupBy("url");
        }

        return $builder;
    }
}
