<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllersTest extends WebTestCase
{
    private static $postId;

    public function testPostInvalidContentType(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/post');
        $this->assertResponseStatusCodeSame(400);
    }

    public function testPostValid(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/post', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                    "title": "Titre annonce DS3 TEST",
                    "content": "Texte annonce ds3",
                    "category": "Motorcar",
                    "carName": "CrossBack ds 3"
                }'
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        self::$postId = $response['data']['id'] ?? null;

        $this->assertResponseStatusCodeSame(200);
    }

    public function testReadInvalidContentType(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/post/1');
        $this->assertResponseStatusCodeSame(400);
    }

    public function testReadValid(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/post/'.self::$postId, [], [], ['CONTENT_TYPE' => 'application/json']);
        $this->assertResponseStatusCodeSame(200);
    }

    public function testUpdateInvalidId(): void
    {
        $client = static::createClient();
        $crawler = $client->request('PUT', '/post/-1', [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                    "title": "Titre annonce DS3 TEST UPDATE",
                    "content": "Texte annonce ds3",
                    "category": "Motorcar",
                    "carName": "CrossBack ds 3"
                }'
        );
        $this->assertResponseStatusCodeSame(400);
    }

    public function testUpdateValid(): void
    {
        $client = static::createClient();
        $crawler = $client->request('PUT', '/post/'.self::$postId, [], [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
                    "title": "Titre annonce DS3 test UPDATE",
                    "content": "Texte annonce ds3",
                    "category": "Motorcar",
                    "carName": "CrossBack ds 3"
                }'
        );
        $this->assertResponseStatusCodeSame(200);
    }

    public function testDeleteInvalidId(): void
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '/post/-1', [], [], ['CONTENT_TYPE' => 'application/json']);
        $this->assertResponseStatusCodeSame(400);
    }

    public function testDeleteValid(): void
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '/post/'.self::$postId, [], [], ['CONTENT_TYPE' => 'application/json']);
        $this->assertResponseStatusCodeSame(200);
    }
}
