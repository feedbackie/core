<?php

declare(strict_types=1);

namespace Feedbackie\Core\Services\GeoIP;

use ReflectionMethod;
use GeoIp2\Database\Reader;
use GeoIp2\Model\Country;

class MaxMindDBReader extends Reader
{
    public function country(string $ipAddress): Country
    {
        //Free database from iplocate has name country
        //Package requires database name Country to work
        //Override type in package to make it working with free DB
        $method = new ReflectionMethod($this, 'modelFor');
        $method->setAccessible(true);

        return $method->invoke($this, Country::class, 'country', $ipAddress);
    }
}
