<?php

if (app()->environment("local")) {
    Route::get("report-widget", [\Feedbackie\Core\Http\Controllers\Testing\ReportFormWidgetController::class, "__invoke"]);
    Route::get("feedback-widget", [\Feedbackie\Core\Http\Controllers\Testing\FeedbackWidgetController::class, "__invoke"]);
}
