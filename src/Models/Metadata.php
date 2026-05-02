<?php

declare(strict_types=1);

namespace Feedbackie\Core\Models;

use Illuminate\Support\Carbon;
use Database\Factories\Feedbackie\Core\Models\MetadataFactory;
use Illuminate\Database\Eloquent\Builder;
use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Contracts\HasUserAndSiteScope;
use Feedbackie\Core\Traits\InteractsWithUserAndSite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $site_id
 * @property string $instance_type
 * @property string $instance_id
 * @property string|null $ip
 * @property string|null $country
 * @property string|null $device
 * @property string|null $os
 * @property string|null $browser
 * @property string|null $language
 * @property string|null $user_agent
 * @property int|null $ts
 * @property int|null $ls
 * @property string|null $ss
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property-read Model|\Eloquent $instance
 * @property-read \App\Models\Site $site
 * @method static MetadataFactory factory($count = null, $state = [])
 * @method static Builder<static>|Metadata newModelQuery()
 * @method static Builder<static>|Metadata newQuery()
 * @method static Builder<static>|Metadata query()
 * @method static Builder<static>|Metadata whereBrowser($value)
 * @method static Builder<static>|Metadata whereCountry($value)
 * @method static Builder<static>|Metadata whereCreatedAt($value)
 * @method static Builder<static>|Metadata whereDevice($value)
 * @method static Builder<static>|Metadata whereId($value)
 * @method static Builder<static>|Metadata whereInstanceId($value)
 * @method static Builder<static>|Metadata whereInstanceType($value)
 * @method static Builder<static>|Metadata whereIp($value)
 * @method static Builder<static>|Metadata whereLanguage($value)
 * @method static Builder<static>|Metadata whereLs($value)
 * @method static Builder<static>|Metadata whereOs($value)
 * @method static Builder<static>|Metadata whereSiteId($value)
 * @method static Builder<static>|Metadata whereSs($value)
 * @method static Builder<static>|Metadata whereTs($value)
 * @method static Builder<static>|Metadata whereUpdatedAt($value)
 * @method static Builder<static>|Metadata whereUserAgent($value)
 * @method static Builder<static>|Metadata whereUserId($value)
 * @mixin \Eloquent
 */
class Metadata extends Model implements HasUserAndSiteScope
{
    use HasFactory;
    use InteractsWithUserAndSite;

    public $table = "metadata";

    public $fillable = [
        "ip",
        "country",
        "device",
        "os",
        "browser"
    ];

    public function instance(): MorphTo
    {
        return $this->morphTo("instance");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(FeedbackieConfiguration::getUserModelClass(), 'user_id', 'id');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(FeedbackieConfiguration::getSiteModelClass(), 'site_id', 'id');
    }

    public function getHashAttribute(): ?string
    {
        return md5($this->attributes['ip'] . $this->attributes['user_agent']);
    }
}
