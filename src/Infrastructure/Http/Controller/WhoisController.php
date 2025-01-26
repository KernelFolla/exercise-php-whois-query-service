<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Service\WhoisService;
use App\Application\Query\WhoisQuery;

/**
 * Class WhoisController
 *
 * Handles HTTP requests for WHOIS queries.
 */
class WhoisController
{
    /**
     * @var WhoisService The service to execute WHOIS queries.
     */
    private readonly WhoisService $whoisService;

    /**
     * WhoisController constructor.
     *
     * @param WhoisService $whoisService The service to execute WHOIS queries.
     */
    public function __construct(WhoisService $whoisService)
    {
        $this->whoisService = $whoisService;
    }

    /**
     * Handles the HTTP request to perform a WHOIS query.
     *
     * @param Request $request The HTTP request.
     * @param Response $response The HTTP response.
     * @param array $args The route arguments.
     * @return Response The HTTP response with the WHOIS query result.
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $query = new WhoisQuery($args['domain']);
            $result = $this->whoisService->execute($query);

            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } catch (\InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => 'Internal Server Error']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}