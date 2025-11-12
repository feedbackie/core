<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Api\Reports;

use Feedbackie\Core\Http\Requests\Api\Reports\SubmitReportRequest;
use Feedbackie\Core\Models\Site;
use Feedbackie\Core\Services\ReportsService;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class SubmitMistakeController
 * @package App\Http\Controllers
 */
class SubmitReportController extends Controller
{
    public function __invoke(string $site, SubmitReportRequest $request, ReportsService $service)
    {
        /** @var Site $siteEntity */
        $siteEntity = Site::findOrFail($site);

        if (false === $siteEntity->report_enabled) {
            throw new AccessDeniedHttpException();
        }

        $service->submitReport($siteEntity, $request->getReport());

        return response()->json(['success' => true]);
    }
}
