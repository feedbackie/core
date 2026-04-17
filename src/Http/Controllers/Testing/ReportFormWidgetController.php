<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Testing;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class ReportFormWidgetController extends Controller
{
    public function __invoke(): Factory|View
    {
        return view("feedbackie-core::testing.report");
    }
}
