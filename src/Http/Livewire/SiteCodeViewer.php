<?php

declare(strict_types=1);

namespace Feedbackie\Core\Http\Livewire;

use Feedbackie\Core\Services\Builders\SiteCodeBuilder;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SiteCodeViewer extends Component
{
    public string $siteId;
    public bool $reportEnabled = false;
    public bool $feedbackEnabled = false;
    public ?string $reportAnchor = null;
    public ?string $feedbackAnchor = null;

    const COMPONENT_NAME = 'feedbackie-core::site-code-viewer';

    public function mount(string $siteId, bool $reportEnabled, bool $feedbackEnabled)
    {
        $this->siteId = $siteId;
        $this->reportEnabled = $reportEnabled;
        $this->feedbackEnabled = $feedbackEnabled;
    }

    #[Computed]
    public function generatedCode(): string
    {
        $builder = (new SiteCodeBuilder($this->siteId))
            ->reportEnabled($this->reportEnabled)
            ->feedbackEnabled($this->feedbackEnabled);

        if ($this->reportEnabled && $this->reportAnchor) {
            $builder->reportAnchorSelector($this->reportAnchor);
        }

        if ($this->feedbackEnabled && $this->feedbackAnchor) {
            $builder->feedbackAnchorSelector($this->feedbackAnchor);
        }

        return $builder->build();
    }

    public function render()
    {
        return view('feedbackie-core::components.site-code-viewer');
    }
}

