<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Api\Feedback;

use Feedbackie\Core\Contracts\CanRetrieveFeedbackStats;
use Feedbackie\Core\Http\Requests\Api\Feedback\StatsFeedbackRequest;
use Feedbackie\Core\Models\Site;
use Feedbackie\Core\Services\FeedbackService;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class StatsFeedbackController extends Controller
{
    public function __invoke(
        string $site,
        StatsFeedbackRequest $request,
        CanRetrieveFeedbackStats $service
    ) {
        /** @var Site $siteEntity */
        $siteEntity = Site::query()->findOrFail($site);

        if (false === $siteEntity->feedback_enabled) {
            throw new AccessDeniedHttpException();
        }

        $stats = $service->getFeedbackStatsByUrl($siteEntity, $request->getUrl());

        return response()->json([
            'success' => true,
            'useful_count' => $stats->useful,
            'not_useful_count' => $stats->notUseful,
        ]);
    }
}
