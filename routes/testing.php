<?php

declare(strict_types=1);

use Feedbackie\Core\Http\Controllers\Testing\ReportFormWidgetController;
use Feedbackie\Core\Http\Controllers\Testing\FeedbackWidgetController;

if (app()->environment("local")) {
    Route::get("report-widget", [ReportFormWidgetController::class, "__invoke"]);
    Route::get("feedback-widget", [FeedbackWidgetController::class, "__invoke"]);
}
