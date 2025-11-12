<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Controllers\Api\Health;

use App\Http\Controllers\Controller;
use Feedbackie\Core\Models\Site;

class SiteHealthController extends Controller
{
    public function __invoke(string $id)
    {
        $site = Site::findOrFail($id);

        return response()->json([
            "success" => true
        ]);
    }
}
