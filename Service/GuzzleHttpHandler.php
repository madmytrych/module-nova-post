<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Service;

use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use GuzzleHttp\RequestOptions;
use Madmytrych\NovaPost\Model\Config;
use Magento\Framework\Webapi\Rest\Request;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpHandler
{
    /**
     * @param \GuzzleHttp\ClientFactory $clientFactory
     * @param \GuzzleHttp\Psr7\ResponseFactory $responseFactory
     * @param \Madmytrych\NovaPost\Model\Config $config
     */
    public function __construct(
        private ClientFactory $clientFactory,
        private ResponseFactory $responseFactory,
        private Config $config
    ) {
    }

    /**
     * Sends API request to NP
     *
     * @param string $novaPostModelName
     * @param string $novaPostCallMethod
     * @param array $novaPostMethodProperties
     * @return mixed
     * @throws \Exception
     */
    public function execute(
        string $novaPostModelName,
        string $novaPostCallMethod,
        array $novaPostMethodProperties = []
    ) {
        $params = [
            Config::API_NP_MODEL_NAME => $novaPostModelName,
            Config::API_NP_CALLED_METHOD => $novaPostCallMethod,
            Config::API_NP_KEY => $this->config->getApiKey()
        ];
        if (!empty($novaPostMethodProperties)) {
            $params[Config::API_NP_METHOD_PROPERTIES] = $novaPostMethodProperties;
        }

        try {
            $response = $this->doRequest($params);
            $responseContent = json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $exception) {
            throw new \Exception($exception->getMessage());
        }
        if (!isset($responseContent['success'])) {
            throw new \Exception(implode(',', $responseContent['errors']));
        }
        return $responseContent['data'];
    }

    /**
     * Sends request to NP
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function doRequest(
        array $params = []
    ): ResponseInterface {
        $client = $this->clientFactory->create();

        return $client->request(
            Request::HTTP_METHOD_POST,
            $this->config->getApiUrl(),
            [RequestOptions::JSON => $params]
        );
    }
}
