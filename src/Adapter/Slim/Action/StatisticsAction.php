<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Action;

use Adex\Api\Adapter\Port\HourlyStatRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class StatisticsAction
{
    private $hourlyStatRepository;

    public function __construct(HourlyStatRepository $hourlyStatRepository)
    {
        $this->hourlyStatRepository = $hourlyStatRepository;
    }

    /**
     * @param int $customerId
     * @param \DateTime $date
     * @param Response $response
     * @return Response
     */
    public function exec(int $customerId, \DateTime $date, Response $response): Response
    {
        $result = $this->hourlyStatRepository->getStatistics($customerId, $date);

        $statistic = [];

        foreach ($result as $row) {
            $statistic[] = [
                "time"=>$row->getTime()->format("H:00")."-".($row->getTime()->format("H")+1).":00",
                "requestCount"=>$row->getRequestCount(),
                "invalidCount"=>$row->getInvalidCount()
            ];
        }

        $response = $response
            ->withStatus(200)
            ->withJson($statistic);

        return $response;
    }
}
