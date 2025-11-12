<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Api\Feedback;

use Feedbackie\Core\Http\Requests\Api\Feedback\SubmitFeedbackRequest;
use Feedbackie\Core\Models\Site;
use Feedbackie\Core\Services\FeedbackService;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SubmitFeedbackController extends Controller
{
    public function __invoke(
        string                $site,
        SubmitFeedbackRequest $request,
        FeedbackService       $service)
    {
        /** @var Site $siteEntity */
        $siteEntity = Site::findOrFail($site);

        if (false === $siteEntity->feedback_enabled) {
            throw new AccessDeniedHttpException();
        }

        $record = $service->makeFeedbackRecord($siteEntity, $request->getFeedbackDto());

        return response()->json([
            'id' => $record->getKey(),
            'success' => true
        ]);
    }
}
