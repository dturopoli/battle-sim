<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BattleControllerTest extends WebTestCase
{
    public function testSuccessRequest(): void
    {
        $client = static::createClient();
        $client->request('GET', '/battle-simulator', [
            'army1' => 200000000,
            'army2' => 200000000,
        ]);

        $this->assertResponseIsSuccessful();
    }
//
//    public function testFailedRequest(): void
//    {
//        $client = static::createClient();
//        $this->client->request('GET', '/', );
//
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorExists('.error-message');
//        $this->assertSelectorNotExists('#battle-stats-table');
//
//        $this->client->request('GET', '/', ['army1' => 1]);
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorExists('.error-message');
//        $this->assertSelectorNotExists('#battle-stats-table');
//
//        $this->client->request('GET', '/', ['army2' => 1]);
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorExists('.error-message');
//        $this->assertSelectorNotExists('#battle-stats-table');
//    }
}
