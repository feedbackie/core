<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services\Builders;

class SiteCodeBuilder
{
    private string $siteId = "";
    private bool $isFeedbackEnabled = true;
    private bool $isReportEnabled = true;
    private string $feedbackAnchorSelector = "";
    private string $reportAnchorSelector = "";
    private ?string $reportInsertType = null;
    private ?string $feedbackInsertType = null;
    private ?int $feedbackStickyRatio = null;
    private ?string $baseUrl = null;
    private ?string $locale = null;

    public function __construct(string $siteId)
    {
        $this->siteId = $siteId;
    }

    public function feedbackEnabled(bool $flag = true): self
    {
        $this->isFeedbackEnabled = $flag;

        return $this;
    }

    public function reportEnabled(bool $flag = true): self
    {
        $this->isReportEnabled = $flag;

        return $this;
    }

    public function feedbackAnchorSelector(string $anchorSelector): self
    {
        $this->feedbackAnchorSelector = $anchorSelector;

        return $this;
    }

    public function reportAnchorSelector(string $anchorSelector): self
    {
        $this->reportAnchorSelector = $anchorSelector;

        return $this;
    }

    public function baseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function locale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function build(): string
    {
        $rendered = view("feedbackie-core::sites.code")
            ->with([
                'siteId' => $this->siteId,
                'feedbackEnabled' => $this->isFeedbackEnabled,
                'reportEnabled' => $this->isReportEnabled,
                'feedbackAnchorSelector' => $this->feedbackAnchorSelector,
                'reportAnchorSelector' => $this->reportAnchorSelector,
                'baseUrl' => $this->baseUrl,
                'locale' => $this->locale,
            ])
            ->render();

        $cleaned = preg_replace('/<!--(.|\s)*?-->/', '', $rendered);
        $cleaned = preg_replace("/[\n]{2}/m", "\n", $cleaned);

        return $cleaned;
    }
}
