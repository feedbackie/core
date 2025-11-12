<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services;

use Feedbackie\Core\Context\ExtendedFeedbackDto;
use Feedbackie\Core\Context\FeedbackDto;
use Feedbackie\Core\Models\Feedback;
use Feedbackie\Core\Models\Site;

class FeedbackService
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

    public function addAdditionalFeedback(Feedback $record, ExtendedFeedbackDto $dto)
    {
        $record->options = $dto->options;
        $record->comment = $dto->comment;
        $record->email = $dto->email;
        $record->language_score = $dto->languageScore;

        $record->save();
    }
}
