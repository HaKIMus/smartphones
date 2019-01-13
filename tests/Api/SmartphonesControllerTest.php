<?php

declare(strict_types=1);

namespace Tests\Api;

use App\Entity\Smartphone\Id;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SmartphonesControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient([], [
            'HTTP_HOST' => 'localhost:8080'
        ]);
    }

    public function testGETMethod(): void
    {
        $this->client->request('GET', '/api/v1/smartphones/');

        $response = $this->client->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testGETMethodReturnsJsonString(): void
    {
        $this->client->request('GET', '/api/v1/smartphones/');

        $response = $this->client->getResponse();

        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));

        $this->assertJson($response->getContent());
    }

    public function testPOSTMethod(): void
    {
        $id = (string) Id::generate();

        $content = [
            'id' => $id,
            'specification' => [
                'model' => '1',
                'company' => 'myphone'
            ],
            'releaseDate' => '02-11-2016'
        ];

        $this->client->request('POST', '/api/v1/smartphones/', [], [], [], json_encode($content));
        
        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->client->request('GET', '/api/v1/smartphones/' . $id);

        $newSmartphoneResponse = $this->client->getResponse();

        $this->assertJson($newSmartphoneResponse->getContent());
    }

    public function testPUTMethod(): void
    {
        $idOfResource = $this->postTestResourceAndGetItsId();

        $this->client->request('GET', '/api/v1/smartphones/' . $idOfResource);

        $smartphoneResponse = $this->client->getResponse();

        $content = [
            'specification' => [
                'model' => '2',
                'company' => 'myphone'
            ],
            'releaseDate' => '02-11-2016'
        ];

        $this->client->request('PUT', '/api/v1/smartphones/' . $idOfResource, [], [], [], json_encode($content));

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->client->request('GET', '/api/v1/smartphones/' . $idOfResource);

        $newSmartphoneResponse = $this->client->getResponse();

        $this->assertJson($newSmartphoneResponse->getContent());

        $oldModel = json_decode($smartphoneResponse->getContent(), true)['specification']['model'];
        $newModel = json_decode($newSmartphoneResponse->getContent(), true)['specification']['model'];

        $this->assertEquals(1, $oldModel);
        $this->assertEquals(2, $newModel);
    }

    public function testPATCHMethod(): void
    {
        $idOfResource = $this->postTestResourceAndGetItsId();

        $this->client->request('GET', '/api/v1/smartphones/' . $idOfResource);

        $smartphoneResponse = $this->client->getResponse();

        $content = [
            'id' => $idOfResource,
            'specification' => [
                'model' => '2',
                'company' => 'myphone'
            ],
            'releaseDate' => '02-11-2016'
        ];

        $this->client->request('PATCH', '/api/v1/smartphones/', [], [], ['CONTENT_TYPE' => true], json_encode($content));

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->client->request('GET', '/api/v1/smartphones/' . $idOfResource);

        $newSmartphoneResponse = $this->client->getResponse();

        $this->assertJson($newSmartphoneResponse->getContent());

        $oldModel = json_decode($smartphoneResponse->getContent(), true)['specification']['model'];
        $newModel = json_decode($newSmartphoneResponse->getContent(), true)['specification']['model'];

        $this->assertEquals(1, $oldModel);
        $this->assertEquals(2, $newModel);
    }

    public function testDELETEMethod(): void
    {
        $idOfResource = $this->postTestResourceAndGetItsId();

        $this->client->request('DELETE', '/api/v1/smartphones/' . $idOfResource);

        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());

        $this->client->request('GET', '/api/v1/smartphones/' . $idOfResource);

        $newSmartphoneResponse = $this->client->getResponse();

        $this->assertJson($newSmartphoneResponse->getContent());

        $this->assertEquals(Response::HTTP_NOT_FOUND, $newSmartphoneResponse->getStatusCode());
    }

    private function postTestResourceAndGetItsId(): string
    {
        $id = (string) Id::generate();

        $content = [
            'id' => $id,
            'specification' => [
                'model' => '1',
                'company' => 'myphone'
            ],
            'releaseDate' => '02-11-2016'
        ];

        $this->client->request('POST', '/api/v1/smartphones/', [], [], [], json_encode($content));

        return $id;
    }
}