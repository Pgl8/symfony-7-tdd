<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginIsShown(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/login');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'TDD login');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("TDD login")')->count());
    }

    public function testRegisterIsShown(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', "Don't have an account yet?");
    }

    public function testRegisterForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Create your account');

        $form = $crawler->selectButton('Register')->form();

        $form['registration_form[username]'] = 'test';
        $form['registration_form[email]'] = 'test@test.com';
        $form['registration_form[plainPassword]'] = 'password1234';
        $form['registration_form[agreeTerms]'] = true;

        $client->submit($form);
        $client->followRedirect();
        $this->assertSelectorTextContains('div', 'You are logged in as test@test.com');

    }
}
