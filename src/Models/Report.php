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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string|null $site_id
 * @property string|null $selected_text
 * @property string|null $full_text
 * @property string|null $fixed_text
 * @property string|null $diff_text
 * @property string|null $url
 * @property string|null $comment
 * @property int $offset
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report currentSite()
 * @method static \Database\Factories\Feedbackie\Core\Models\ReportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDiffText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereFixedText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereFullText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereOffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereSelectedText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report withoutTrashed()
 * @mixin \Eloquent
 */
class Report extends Model implements HasUserAndSiteScope
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    use HasCurrentSiteScope;
    use InteractsWithUserAndSite;

    public $fillable = [
        "selected_text",
        "full_text",
        "fixed_text",
        "url",
        "comment",
        "offset",
        "created_at",
        "updated_at"
    ];

    public function getMorphClass()
    {
        return 'report';
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(FeedbackieConfiguration::getSiteModelClass(), "site_id", "id");
    }

    public function metadata(): MorphOne
    {
        return $this->morphOne(FeedbackieConfiguration::getMetadataModelClass(), 'instance');
    }
}
