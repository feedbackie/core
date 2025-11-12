<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Api\Health;

use Illuminate\Routing\Controller;

class HealthController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            "success" => true
        ]);
    }
}
