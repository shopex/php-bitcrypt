# php-bitcrypt

# 1. Require with Composer
```
composer require shopex/phpbitcrypt
```

# 2. Example
```
use GuzzleHttp\Client;
use Edwinlll\PhpBitcrypt\Rsa;
use Monolog\Logger;

$rsa = new Rsa(function() {
            return new Client([
                "base_uri" => "http://127.0.0.1:9989"
            ]);
        }, $logger);
$response = $rsa->encrypt("token", "data");
if($response->getStatusCode() == 200) {
    $rst = $response->json();
    $data = $response->json("data", "default data");
}
```
