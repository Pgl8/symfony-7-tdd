<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testWelcomePage(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/');

        // Validate a successful response and some content
        $text = "Symfony TDD";
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', $text);

        $this->assertGreaterThan(0, $crawler->filter("html:contains('$text')")->count());
    }

    public function testWelcomePageButtonRedirection(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertSelectorTextContains('a', 'Start');
        $link = $crawler->selectLink('Start')->link();
        $client->click($link);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'TDD login');
    }
}
