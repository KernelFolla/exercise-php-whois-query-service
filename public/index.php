<?php

declare(strict_types=1);

use App\Application\Service\WhoisService;
use App\Infrastructure\Adapter\WhoisAdapter;
use App\Infrastructure\Http\Controller\WhoisController;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$whoisAdapter = new WhoisAdapter(
    getenv('WHOIS_SERVER'),
    (int)getenv('WHOIS_PORT'),
    (int)getenv('WHOIS_TIMEOUT')
);
$whoisService = new WhoisService($whoisAdapter);
$whoisController = new WhoisController($whoisService);

$app->get('/whois/{domain}', $whoisController);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
if(getenv('DEBUG') !== 'true') {
    $errorMiddleware->setErrorHandler(\Throwable::class, function ($request, $exception, $displayErrorDetails) {
        $payload = ['error' => 'Internal Server Error'];
        $response = new Response();
        $response->getBody()->write(json_encode($payload));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    });

    $errorMiddleware->setErrorHandler(HttpNotFoundException::class, function ($request, $exception, $displayErrorDetails) {
        $payload = ['error' => 'Not Found'];
        $response = new Response();
        $response->getBody()->write(json_encode($payload));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
    });
}

$app->run();