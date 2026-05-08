<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services\Builders;

class SiteCodeBuilder
{
    private string $siteId = "";
    private bool $isFeedbackEnabled = true;
    private bool $isReportEnabled = true;
    private bool $isReportMessageEnabled = true;
    private bool $isReportButtonEnabled = true;
    private string $feedbackAnchorSelector = "";
    private string $reportMessageAnchorSelector = "";
    private ?string $reportMessageInsertType = null;
    private ?string $feedbackWidgetInsertType = null;
    private ?string $baseUrl = null;
    private ?string $locale = null;
    private float $feedbackStickyRatio = 0;
    private float $feedbackStickyPercent = 50;
    private string $feedbackWidgetTheme = 'adaptive';
    private bool $displayPoweredBy = false;

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

    public function reportMessageEnabled(bool $flag = true): self
    {
        $this->isReportMessageEnabled = $flag;

        return $this;
    }

    public function reportButtonEnabled(bool $flag = true): self
    {
        $this->isReportButtonEnabled = $flag;

        return $this;
    }

    public function feedbackWidgetAnchorSelector(string $anchorSelector): self
    {
        $this->feedbackAnchorSelector = $anchorSelector;

        return $this;
    }

    public function reportMessageAnchorSelector(string $anchorSelector): self
    {
        $this->reportMessageAnchorSelector = $anchorSelector;

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

    public function feedbackStickyRato(float $ratio): self
    {
        $this->feedbackStickyRatio = $ratio;

        return $this;
    }

    public function feedbackStickyPercent(float $percent): self
    {
        $this->feedbackStickyPercent = $percent;

        return $this;
    }

    public function feedbackWidgetTheme(string $theme): self
    {
        $this->feedbackWidgetTheme = $theme;

        return $this;
    }

    public function displayPoweredBy(bool $flag = true): self
    {
        $this->displayPoweredBy = $flag;

        return $this;
    }

    public function build(): string
    {
        $rendered = view("feedbackie-core::sites.code")
            ->with([
                'siteId' => $this->siteId,
                'feedbackEnabled' => $this->isFeedbackEnabled,
                'reportEnabled' => $this->isReportEnabled,
                'reportMessageEnabled' => $this->isReportMessageEnabled,
                'reportButtonEnabled' => $this->isReportButtonEnabled,
                'reportMessageAnchorSelector' => $this->reportMessageAnchorSelector,
                'feedbackWidgetAnchorSelector' => $this->feedbackAnchorSelector,
                'feedbackWidgetTheme' => $this->feedbackWidgetTheme,
                'feedbackStickyRatio' => $this->feedbackStickyRatio,
                'feedbackStickyPercent' => $this->feedbackStickyPercent,
                'displayPoweredBy' => $this->displayPoweredBy,
                'baseUrl' => $this->baseUrl,
                'locale' => $this->locale,
            ])
            ->render();

        $cleaned = preg_replace('/<!--(.|\s)*?-->/', '', $rendered);
        $cleaned = preg_replace("/[\n]{2}/m", "\n", $cleaned);

        return $cleaned;
    }
}
