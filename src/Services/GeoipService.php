<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services;

use Feedbackie\Core\Context\CountryDto;
use Feedbackie\Core\Services\GeoIP\DatabaseDownloader;
use Feedbackie\Core\Services\GeoIP\MaxMindDBReader;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use GeoIp2\Model\Country;
use Illuminate\Support\Facades\Log;
use MaxMind\Db\Reader\InvalidDatabaseException;

class GeoipService
{
    private ?Reader $reader = null;

    private string $databaseDir;
    private string $databaseFile;

    public function __construct()
    {
        $this->databaseDir = storage_path('geoip');
        $this->databaseFile = $this->databaseDir . '/database.mmdb';

        try {
            if (file_exists($this->databaseFile)) {
                $this->reader = new MaxMindDBReader($this->databaseFile);
            }
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    public function shouldDownloadDatabase(): bool
    {
        if (false === file_exists($this->databaseFile)) {
            return true;
        }

        if (time() - filemtime($this->databaseFile) >= 86400) {
            return true;
        }

        return false;
    }

    public function downloadDatabase(): void
    {
        $url = 'https://github.com/iplocate/ip-address-databases/raw/refs/heads/main/ip-to-country/ip-to-country.mmdb';

        if (false === file_exists($this->databaseDir)) {
            mkdir($this->databaseDir);
        }

        $downloader = new DatabaseDownloader();

        $downloader->downloadDatabase($url, $this->databaseFile);
    }

    public function getCountry(string $ip): CountryDto
    {
        if (null === $this->reader) {
            return new CountryDto(name: "Unrecognized");
        }

        try {
            /** @var Country $country */
            $country = $this->reader->country($ip);

            return new CountryDto(
                name: $country->raw['country_name'] ?? "Unrecognized",
                code: $country->raw['country_code'] ?? null,
            );
        } catch (AddressNotFoundException $e) {
            return new CountryDto("Unrecognized");
        } catch (InvalidDatabaseException $e) {
            if (app()->environment("local")) {
                throw $e;
            }

            Log::error($e->getMessage());

            return new CountryDto("Unrecognized");
        } catch (\Throwable $e) {
            if (app()->environment("local")) {
                throw $e;
            }

            Log::error($e->getMessage());

            return new CountryDto("Unrecognized");
        }
    }
}
