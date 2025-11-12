<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Api\Feedback;

use Feedbackie\Core\Http\Requests\Api\Feedback\UpdateFeedbackRequest;
use Feedbackie\Core\Models\Feedback;
use Feedbackie\Core\Models\Site;
use Feedbackie\Core\Services\FeedbackService;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UpdateFeedbackController extends Controller
{
    public function __invoke(
        string $site,
        string $id,
        UpdateFeedbackRequest $request,
        FeedbackService $service
    )
    {
        $site = Site::findOrFail($site);
        $record = Feedback::findOrFail($id);

        if ($site->getKey() !== $record->site->getKey()) {
            throw new AccessDeniedHttpException();
        }

        if (now()->diffInMinutes($record->created_at) > 10) {
            throw new AccessDeniedHttpException();
        }

        if ($record->created_at != $record->updated_at) {
            throw new AccessDeniedHttpException();
        }

        $service->addAdditionalFeedback(
            $record,
            $request->getExtendedFeedback()
        );

        return response()->json([
            'success' => true
        ]);
    }
}
