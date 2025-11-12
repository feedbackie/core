<?php

declare(strict_types=1);

namespace Feedbackie\Core\Models;

use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Contracts\HasUserScope;
use Feedbackie\Core\Contracts\UserContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $domain
 * @property bool $report_enabled
 * @property bool $feedback_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property string|null $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Feedback> $feedbacks
 * @property-read int|null $feedbacks_count
 * @property-read \App\Models\Metadata|null $lastEvent
 * @property-read mixed $last_event_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reports
 * @property-read int|null $reports_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiteView> $viewsMonth
 * @property-read int|null $views_month_count
 * @method static \Database\Factories\SiteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereFeedbackEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereReportEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereUserId($value)
 * @mixin \Eloquent
 */
class Site extends Model implements HasUserScope
{
    use HasFactory;
    use HasUuids;

    public $fillable = [
        "name",
        "domain",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(FeedbackieConfiguration::getUserModelClass(), 'user_id', 'id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(FeedbackieConfiguration::getReportModelClass(), 'site_id', 'id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(FeedbackieConfiguration::getFeedbackModelClass(), 'site_id', 'id');
    }

    public function lastEvent(): HasOne
    {
        return $this->hasOne(FeedbackieConfiguration::getMetadataModelClass(), 'site_id', 'id')
            ->orderByDesc("created_at")
            ->limit(1);
    }

    public function setUser(UserContract $user): void
    {
        $this->user()->associate($user);
    }

    public function getUser(): UserContract
    {
        return $this->user;
    }

    protected function lastEventDate(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->lastEvent?->created_at;
            },
        );
    }
}
