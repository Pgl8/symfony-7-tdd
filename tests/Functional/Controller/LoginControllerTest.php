<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    private $client;
    private $testUserEmail;
    private $testUserPassword;
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $container = static::getContainer();
        $this->testUserEmail = $container->getParameter('app.test_user_email');
        $this->testUserPassword = $container->getParameter('app.test_user_password');
    }

    public function testLoginIsShown(): void
    {
        // Request a specific page
        $crawler = $this->client->request('GET', '/login');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'TDD login');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("TDD login")')->count());
    }
}
