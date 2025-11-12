<?php

declare(strict_types=1);

namespace Feedbackie\Core\Models;

use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Traits\HasCurrentSiteScope;
use Feedbackie\Core\Contracts\HasUserAndSiteScope;
use Feedbackie\Core\Traits\InteractsWithUserAndSite;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string $id
 * @property string|null $site_id
 * @property string $answer
 * @property string|null $comment
 * @property array<array-key, mixed>|null $options
 * @property string $url
 * @property string $url_hash
 * @property string|null $hash
 * @property int|null $language_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property string|null $email
 * @property-read \App\Models\Metadata|null $metadata
 * @property-read \App\Models\Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback currentSite()
 * @method static \Database\Factories\Feedbackie\Core\Models\FeedbackFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereLanguageScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereUrlHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereUserId($value)
 * @mixin \Eloquent
 */
class Feedback extends Model implements HasUserAndSiteScope
{
    use HasFactory;
    use HasUuids;
    use HasCurrentSiteScope;
    use InteractsWithUserAndSite;

    public $casts = [
        'options' => 'array'
    ];

    public $fillable = [
        'answer',
        'comment',
        'options',
        'url',
        'url_hash',
        'hash',
        'language_score',
        'email',
        "created_at",
        "updated_at",
    ];

    public function getMorphClass()
    {
        return 'feedback';
    }

    public function metadata(): MorphOne
    {
        return $this->morphOne(FeedbackieConfiguration::getMetadataModelClass(), 'instance');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(FeedbackieConfiguration::getSiteModelClass(), "site_id", "id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(FeedbackieConfiguration::getUserModelClass(), "user_id", "id");
    }
}
