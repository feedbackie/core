<?php

declare(strict_types=1);

namespace Feedbackie\Core\Console\Commands;

use Feedbackie\Core\Services\GeoipService;
use Illuminate\Console\Command;

class DownloadGeoIpDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-geoip-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GeoipService $geoipService)
    {
        if($geoipService->shouldDownloadDatabase() === false) {
            $this->info("Geoip database is up to date. No need to download.");

            return self::SUCCESS;
        }

        $this->info("Downloading geoip database...");

        $geoipService->downloadDatabase();

        $this->info("Done.");

        return self::SUCCESS;
    }
}
