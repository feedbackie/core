<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Testing;

use App\Http\Controllers\Controller;

class ReportFormWidgetController extends Controller
{
    public function __invoke()
    {
        return view("feedbackie-core::testing.report");
    }
}
