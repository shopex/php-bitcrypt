<?php

declare(strict_types=1);

namespace Shopex\PhpBitcrypt;

use Closure;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use Shopex\PhpBitcrypt\Exception\ClientException;
use Shopex\PhpBitcrypt\Exception\ServerException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class Client
{
    /**
     * @var string
     */
    const DEFAULT_URI = "http://127.0.0.1:8848";

    /**
     * @var Closure
     */
    private $clientFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Client constructor.
     * @param Closure $clientFactory
     */
    public function __construct(Closure $clientFactory, LoggerInterface $logger = null)
    {
        $this->clientFactory = $clientFactory;
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * @param array $options
     * @param array $availableOptions
     * @return array
     */
    protected function resolveOptions(array $options, array $availableOptions): array
    {
        return array_intersect_key($options, array_flip($availableOptions));
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return PhpBitcryptResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(string $method, string $url, array $options = []): PhpBitcryptResponse
    {
        $this->logger->debug(sprintf("PhpBitcrypt Request [%s] %s", strtoupper($method), $url));
        try {
            $clientFactory = $this->clientFactory;
            $client = $clientFactory($options);
            if (!$client instanceof ClientInterface) {
                throw new ClientException(sprintf('The client factory should create a %s instance.', ClientInterface::class));
            }
            $response = $client->request($method, $url, $options);
        } catch (TransferException $e) {
            $message = sprintf("Something went wrong when calling nacos (%s).", $e->getMessage());
            $this->logger->error($message);
            throw new ServerException($e->getMessage(), $e->getCode(), $e);
        }
        return new PhpBitcryptResponse($response);
    }
}