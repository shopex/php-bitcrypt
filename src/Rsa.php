<?php

declare(strict_types=1);

namespace Shopex\PhpBitcrypt;


class Rsa extends Client implements RsaInterface
{

    public function encrypt(string $token ,string $data) : PhpBitcryptResponse{
        $params = [
            "query" => [
                "token" => $token,
                "data" => $data,
            ],
        ];
        return $this->request("POST", "/api/v1/rsa/encrypt", $params);
    }

    public function decrypt(string $token, string $data) : PhpBitcryptResponse{
        $params = [
            "query" => [
                "token" => $token,
                "data" => $data,
            ]
        ];
        return $this->request("POST", "/api/v1/rsa/decrypt", $params);
    }

}