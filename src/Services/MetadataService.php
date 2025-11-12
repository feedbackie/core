<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services;

use Feedbackie\Core\Context\TimestampsDto;
use Feedbackie\Core\Models\Metadata;
use foroco\BrowserDetection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

class MetadataService
{
    private GeoipService $geoipServcie;
    private Request $request;

    public function __construct(GeoipService $geoipServcie, Request $request)
    {
        $this->geoipServcie = $geoipServcie;
        $this->request = $request;
    }

    public function getMetadataForCurrentRequest(): Metadata
    {
        $countryMeta = $this->geoipServcie->getCountry($this->request->ip());

        $metadata = new Metadata();

        $metadata->ip = IpUtils::anonymize($this->request->ip());
        $metadata->country = $countryMeta->name;
        $metadata->country_code = $countryMeta->code;

        $parser = new BrowserDetection();
        $browserInfo = $parser->getBrowser($this->request->userAgent());

        $metadata->browser = ($browserInfo["browser_name"] ?? null) . " " . ($browserInfo["browser_version"] ?? null);
        $metadata->device = $parser->getDevice($this->request->userAgent())["device_type"] ?? null;
        $metadata->os = $parser->getOS($this->request->userAgent())["os_name"] ?? null;
        $metadata->user_agent = $this->request->userAgent();

        $metadata->language = $this->request->getPreferredLanguage();

        $timestapms = $this->getTimingsFromRequest($this->request);
        $metadata->ts = $timestapms->ts;
        $metadata->ls = $timestapms->ls;
        $metadata->ss = $timestapms->ss;

        return $metadata;
    }

    private function getTimingsFromRequest(Request $request): TimestampsDto
    {
        $dto = new TimestampsDto(
            ss: $request->get("ss"), //session id
            ts: intval($request->get("ts")), //timestamp on sending request
            ls: intval($request->get("ls")), //script loading timestamp
        );

        return $dto;
    }
}
