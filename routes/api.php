<?php

declare(strict_types=1);

use Feedbackie\Core\Http\Controllers\Api\Reports\SubmitReportController;
use Feedbackie\Core\Configuration\FeedbackieConfiguration;
use Feedbackie\Core\Utils\Uuid;
use Feedbackie\Core\Http\Controllers\Api\Feedback\SubmitFeedbackController;
use Feedbackie\Core\Http\Controllers\Api\Feedback\UpdateFeedbackController;
use Feedbackie\Core\Http\Controllers\Api\Health\SiteHealthController;
use Feedbackie\Core\Http\Controllers\Api\Health\HealthController;
use Feedbackie\Core\Http\Controllers\Api\Feedback\StatsFeedbackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'api'], function (): void {

    Route::post(
        '/site/{site}/report',
        SubmitReportController::class
    )
        ->middleware(FeedbackieConfiguration::getReportsApiMiddlewareList())
        ->where("site", Uuid::getRegex());

    Route::post(
        '/site/{site}/feedback',
        SubmitFeedbackController::class
    )
        ->middleware(FeedbackieConfiguration::getFeedbacksApiMiddlewareList())
        ->where("site", Uuid::getRegex());

    Route::get(
        '/site/{site}/feedback',
        StatsFeedbackController::class
    )
        ->where("site", Uuid::getRegex());


    Route::put(
        '/site/{site}/feedback/{id}',
        UpdateFeedbackController::class
    )
        ->where("site", Uuid::getRegex())
        ->where("id", Uuid::getRegex());

    Route::get(
        '/site/{site}/health',
        SiteHealthController::class,
    )->where("site", Uuid::getRegex());

    Route::get("/health", HealthController::class);
});
