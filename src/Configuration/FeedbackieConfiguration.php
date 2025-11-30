<?php

declare(strict_types=1);

namespace Feedbackie\Core\Configuration;

use Illuminate\Http\Request;

class FeedbackieConfiguration
{
    public static function getUserModelClass(): string
    {
        return config('feedbackie.user_model');
    }

    public static function getSiteModelClass(): string
    {
        return config('feedbackie.site_model');
    }

    public static function getFeedbackModelClass(): string
    {
        return config('feedbackie.feedback_model');
    }

    public static function getReportModelClass(): string
    {
        return config('feedbackie.report_model');
    }

    public static function getMetadataModelClass(): string
    {
        return config('feedbackie.metadata_model');
    }

    public static function getFeedbacksApiMiddlewareList(): array
    {
        return config('feedbackie.api.feedbacks_middleware');
    }

    public static function getReportsApiMiddlewareList(): array
    {
        return config('feedbackie.api.reports_middleware');
    }

    public static function isRouteSiteDependent()
    {
        $siteDependentRoutes = [
            'dashboard',
            'feedback',
            'feedback-stats',
            'reports',
            'report-stats',
            'usage'
        ];

        $request = app()->get(Request::class);
        $path = $request->getPathInfo();
        $fragment = last(explode("/", $path));

        if (in_array($fragment, $siteDependentRoutes)) {
            return true;
        } else {
            return false;
        }
    }
}
