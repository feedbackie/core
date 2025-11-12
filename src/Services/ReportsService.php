<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services;

use Feedbackie\Core\Context\ReportDto;
use Feedbackie\Core\Models\Report;
use Feedbackie\Core\Models\Site;
use Feedbackie\Core\Utils\Differ;

class ReportsService
{
    private Differ $differ;
    private MetadataService $metadataService;

    public function __construct(Differ $differ, MetadataService $metadataService)
    {
        $this->differ = $differ;
        $this->metadataService = $metadataService;
    }

    public function submitReport(Site $site, ReportDto $dto): void
    {
        $original = $dto->fullText;
        $original = str_replace('[sel]', '', $original);
        $original = str_replace('[/sel]', '', $original);

        $report = new Report($dto->toArray());
        $report->diff_text = $this->differ->compareStrings($original, $dto->fixedText);
        $report->site()->associate($site);
        $report->save();

        $metadata = $this->metadataService->getMetadataForCurrentRequest();
        $metadata->instance()->associate($report);
        $metadata->site()->associate($site);
        $metadata->save();
    }
}
