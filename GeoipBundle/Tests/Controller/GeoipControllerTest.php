<?php

namespace Nabludai\GeoipBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GeoipControllerTest extends WebTestCase
{
    public function testGetcountrystate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/geoip/country');
    }

}
