<?php

namespace Liip\ThemeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ThemeControllerTest extends WebTestCase
{
    public function testSettheme()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/setTheme');
    }

}
