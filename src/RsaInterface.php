<?php

declare(strict_types=1);

namespace Shopex\PhpBitcrypt;


interface RsaInterface
{
    public function encrypt(string $token, string $data): PhpBitcryptResponse;

    public function decrypt(string $token, string $data): PhpBitcryptResponse;
}