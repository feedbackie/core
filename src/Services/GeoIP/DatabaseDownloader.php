<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services\GeoIP;

use Feedbackie\Core\Services\GeoIP\Exception\DownloadGeoIPDatabaseException;

class DatabaseDownloader
{
    public function downloadDatabase(string $url, string $filePath): void
    {
        $tempFilePath = tempnam(sys_get_temp_dir(), 'mmdb');
        $fp = fopen($tempFilePath, 'w+');

        if ($fp === false) {
            throw new DownloadGeoIPDatabaseException("Cannot open file for writing: $tempFilePath");
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300); // 5 minutes timeout

        $success = curl_exec($ch);
        $error = curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        fclose($fp);

        if (!$success) {
            unlink($tempFilePath);
            throw new DownloadGeoIPDatabaseException("cURL Error: $error");
        }

        if ($statusCode >= 400) {
            unlink($tempFilePath);
            throw new DownloadGeoIPDatabaseException("HTTP Error $statusCode");
        }

        rename($tempFilePath, $filePath);
    }
}
