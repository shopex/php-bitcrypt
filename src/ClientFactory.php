<?php

declare(strict_types=1);

namespace Shopex\PhpBitcrypt;


class ClientFactory
{
    /**
     * ClientFactory constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param array $options
     * @return \GuzzleHttp\Client
     */
    public function create(array $options = []): \GuzzleHttp\Client
    {
        return new \GuzzleHttp\Client($options);
    }
}