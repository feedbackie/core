<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Testing;

use App\Http\Controllers\Controller;

class FeedbackWidgetController extends Controller
{
    public function __invoke()
    {
        return view("feedbackie-core::testing.feedback");
    }
}
