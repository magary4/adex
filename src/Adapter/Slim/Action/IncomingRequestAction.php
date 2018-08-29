<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Action;

use Adex\Api\Adapter\Port\HourlyStatRepository;
use Adex\Api\Adapter\Request\Payload;
use Slim\Http\Body;
use Slim\Http\Headers;
use Slim\Http\Response;

class IncomingRequestAction
{
    private $hourlyStatRepository;

    public function __construct(HourlyStatRepository $hourlyStatRepository)
    {
        $this->hourlyStatRepository = $hourlyStatRepository;
    }

    public function exec(Payload $payload, Response $response): Response
    {
        $this->hourlyStatRepository->update($payload->getCustomerId(), $payload->getTime());

        $response = $response
            ->withStatus(201)
            ->withJson(["success"=>true]);

        return $response;
    }
}
