<?php

declare(strict_types=1);

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

Route::group(['prefix' => 'api'], function () {

    Route::post(
        '/site/{site}/report',
        \Feedbackie\Core\Http\Controllers\Api\Reports\SubmitReportController::class
    )
        ->middleware(\Feedbackie\Core\Configuration\FeedbackieConfiguration::getReportsApiMiddlewareList())
        ->where("site", \Feedbackie\Core\Utils\Uuid::getRegex());

    Route::post(
        '/site/{site}/feedback',
        \Feedbackie\Core\Http\Controllers\Api\Feedback\SubmitFeedbackController::class
    )
        ->middleware(\Feedbackie\Core\Configuration\FeedbackieConfiguration::getFeedbacksApiMiddlewareList())
        ->where("site", \Feedbackie\Core\Utils\Uuid::getRegex());

    Route::put(
        '/site/{site}/feedback/{id}',
        \Feedbackie\Core\Http\Controllers\Api\Feedback\UpdateFeedbackController::class
    )
        ->where("site", \Feedbackie\Core\Utils\Uuid::getRegex())
        ->where("id", \Feedbackie\Core\Utils\Uuid::getRegex());

    Route::get(
        '/site/{site}/health',
        \Feedbackie\Core\Http\Controllers\Api\Health\SiteHealthController::class,
    )->where("site", \Feedbackie\Core\Utils\Uuid::getRegex());

    Route::get("/health", \Feedbackie\Core\Http\Controllers\Api\Health\HealthController::class);
});
