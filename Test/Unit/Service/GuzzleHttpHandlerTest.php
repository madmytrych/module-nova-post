<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use Madmytrych\NovaPost\Service\GuzzleHttpHandler;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Madmytrych\NovaPost\Model\Config;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Magento\Framework\Webapi\Rest\Request;

class GuzzleHttpHandlerTest extends TestCase
{
    /**
     * @var \GuzzleHttp\ClientFactory
     */
    private $clientFactoryMock;

    /**
     * @var \GuzzleHttp\Psr7\ResponseFactory
     */
    private $responseFactoryMock;

    /**
     * @var \Madmytrych\NovaPost\Model\Config
     */
    private $configMock;

    /**
     * @var \GuzzleHttp\Client
     */
    private $clientMock;

    /**
     * @var \Madmytrych\NovaPost\Service\GuzzleHttpHandler
     */
    private $guzzleHttpHandler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->clientFactoryMock = $this->createMock(ClientFactory::class);
        $this->responseFactoryMock = $this->createMock(ResponseFactory::class);
        $this->configMock = $this->createMock(Config::class);
        $this->clientMock = $this->createMock(Client::class);
        $this->clientFactoryMock
            ->method('create')
            ->willReturn($this->clientMock);
        $this->guzzleHttpHandler = new GuzzleHttpHandler(
            $this->clientFactoryMock,
            $this->responseFactoryMock,
            $this->configMock
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testExecuteSuccess()
    {
        $apiKey = 'test-api-key';
        $apiUrl = 'https://api.novapost.com/';
        $model = 'Address';
        $method = 'getCities';
        $params = ['CityName' => 'Kyiv'];
        $this->configMock->method('getApiKey')->willReturn($apiKey);
        $this->configMock->method('getApiUrl')->willReturn($apiUrl);
        $responseBody = $this->createMock(StreamInterface::class);
        $responseBody->method('getContents')->willReturn(json_encode([
            'success' => true,
            'data' => ['city1', 'city2']
        ]));
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($responseBody);
        $this->clientMock->method('request')
            ->with(
                Request::HTTP_METHOD_POST,
                $apiUrl,
                [
                    'json' => [
                        Config::API_NP_MODEL_NAME => $model,
                        Config::API_NP_CALLED_METHOD => $method,
                        Config::API_NP_KEY => $apiKey,
                        Config::API_NP_METHOD_PROPERTIES => $params
                    ]
                ]
            )
            ->willReturn($responseMock);
        $result = $this->guzzleHttpHandler->execute($model, $method, $params);
        $this->assertEquals(['city1', 'city2'], $result);
    }

    public function testExecuteFailure()
    {
        $this->expectException(\Exception::class);
        $apiKey = 'test-api-key';
        $apiUrl = 'https://api.novapost.com/';
        $model = 'Address';
        $method = 'getCities';
        $params = ['CityName' => 'Kyiv'];
        $this->configMock->method('getApiKey')->willReturn($apiKey);
        $this->configMock->method('getApiUrl')->willReturn($apiUrl);
        $responseBody = $this->createMock(StreamInterface::class);
        $responseBody->method('getContents')->willReturn(json_encode([
            'errors' => ['error1', 'error2']
        ]));
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn($responseBody);
        $this->clientMock->method('request')
            ->with(
                Request::HTTP_METHOD_POST,
                $apiUrl,
                [
                    'json' => [
                        Config::API_NP_MODEL_NAME => $model,
                        Config::API_NP_CALLED_METHOD => $method,
                        Config::API_NP_KEY => $apiKey,
                        Config::API_NP_METHOD_PROPERTIES => $params
                    ]
                ]
            )
            ->willReturn($responseMock);

        $this->guzzleHttpHandler->execute($model, $method, $params);
    }

    public function testExecuteGuzzleException()
    {
        $this->expectException(\Exception::class);

        $apiKey = 'test-api-key';
        $apiUrl = 'https://api.novapost.com/';
        $model = 'Address';
        $method = 'getCities';
        $params = ['CityName' => 'Kyiv'];

        $this->configMock->method('getApiKey')->willReturn($apiKey);
        $this->configMock->method('getApiUrl')->willReturn($apiUrl);

        $this->clientMock->method('request')
            ->with(
                Request::HTTP_METHOD_POST,
                $apiUrl,
                [
                    'json' => [
                        Config::API_NP_MODEL_NAME => $model,
                        Config::API_NP_CALLED_METHOD => $method,
                        Config::API_NP_KEY => $apiKey,
                        Config::API_NP_METHOD_PROPERTIES => $params
                    ]
                ]
            )
            ->will($this->throwException(
                new RequestException('Error', $this->createMock(
                    RequestInterface::class
                ))
            ));

        $this->guzzleHttpHandler->execute($model, $method, $params);
    }
}
