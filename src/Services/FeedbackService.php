<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services;

use Feedbackie\Core\Context\ExtendedFeedbackDto;
use Feedbackie\Core\Context\FeedbackDto;
use Feedbackie\Core\Context\FeedbackStatsDto;
use Feedbackie\Core\Contracts\CanRetrieveFeedbackStats;
use Feedbackie\Core\Models\Feedback;
use Feedbackie\Core\Models\FeedbackStats;
use Feedbackie\Core\Models\Site;
use Illuminate\Support\Facades\DB;

class FeedbackService implements CanRetrieveFeedbackStats
{
    private MetadataService $metadataService;

    public function __construct(MetadataService $metadataService)
    {
        $this->metadataService = $metadataService;
    }

    public function makeFeedbackRecord(Site $site, FeedbackDto $dto): Feedback
    {
        $helpful = new Feedback($dto->toArray());
        $helpful->site()->associate($site);
        $helpful->save();

        $metadata = $this->metadataService->getMetadataForCurrentRequest();
        $metadata->instance()->associate($helpful);
        $metadata->site()->associate($site);
        $metadata->save();

        return $helpful;
    }

    public function addAdditionalFeedback(Feedback $record, ExtendedFeedbackDto $dto): void
    {
        $record->options = $dto->options;
        $record->comment = $dto->comment;
        $record->email = $dto->email;
        $record->language_score = $dto->languageScore;

        $record->save();
    }

    public function getFeedbackStatsByUrl(string $url): FeedbackStatsDto
    {
        $feedbackTable = (new Feedback())->getTable();
        $stats = DB::table($feedbackTable)
            ->selectRaw("url")
            ->selectRaw("count(*) FILTER (WHERE answer = 'yes') AS yes_count")
            ->selectRaw("count(*) FILTER (WHERE answer = 'no') AS no_count")
            ->groupBy("url")
            ->where('url', $url)
            ->first();

        return new FeedbackStatsDto(
            useful: $stats->yes_count ?? 0,
            notUseful: $stats->no_count ?? 0,
        );
    }
}
