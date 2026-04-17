<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Api\Feedback;

use Feedbackie\Core\Contracts\CanRetrieveFeedbackStats;
use Feedbackie\Core\Http\Requests\Api\Feedback\StatsFeedbackRequest;
use Feedbackie\Core\Services\FeedbackService;
use Illuminate\Routing\Controller;

class StatsFeedbackController extends Controller
{
    public function __invoke(StatsFeedbackRequest $request, CanRetrieveFeedbackStats $service)
    {
        $stats = $service->getFeedbackStatsByUrl($request->getUrl());

        return response()->json([
            'useful' => $stats->useful,
            'not_useful' => $stats->notUseful,
        ]);
    }
}
