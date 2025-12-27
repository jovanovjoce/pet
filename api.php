<?php
require __DIR__ . '/vendor/autoload.php';

use Tqdev\PhpCrudApi\Config\Config;
use Tqdev\PhpCrudApi\Api;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7\Factory\Psr17Factory;

// Конфигурација за MySQL
$config = new Config([
    'driver' => 'mysql',
    'address' => 'localhost',
    'port' => '3306',
    'username' => 'pet',
    'password' => 'pet',
    'database' => 'pet',
]);

// Креирај PSR-7 ServerRequest од глобалните променливи
$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
$request = $creator->fromGlobals();

// Стартувај API
$api = new Api($config);
$response = $api->handle($request);

// Испрати HTTP одговор назад кон клиентот
http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
echo $response->getBody();
