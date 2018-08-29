<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Action;

use Adex\Api\Adapter\Port\HourlyStatRepository;
use Adex\Api\Adapter\Request\Payload;
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
//        return $response->withStatus( 500 )
//            ->withHeader( 'Content-Type', 'application/json' )
//            ->write( json_encode([ "status" => "success" ]) );

        $this->hourlyStatRepository->update($payload->getCustomerId(), $payload->getTime());

        $response = $response->write("success");

        return $response;
    }
}
