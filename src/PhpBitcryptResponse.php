<?php

declare(strict_types=1);

namespace Shopex\PhpBitcrypt;


use Shopex\PhpBitcrypt\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PhpBitcryptResponse
 * @package Shopex\PhpBitcrypt
 */
class PhpBitcryptResponse
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * PhpBitcryptResponse constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return  $this->response->{$name}(...$arguments);
    }

    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed|mixed
     */
    public function json(string $key = null, $default = null)
    {

        if (strstr( strtolower($this->response->getHeaderLine('Content-Type')), 'application/json') === false ) {
            throw new ServerException('The Content-Type of response is not equal application/json');
        }
        $data = json_decode($this->response->getBody()->getContents(), true);
        if (is_null($key)) {
            return $data;
        }
        if (array_key_exists($key, $data)) {
            return $data[$key];
        } else {
            return $default;
        }
    }
}