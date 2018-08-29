<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Middleware;

use Adex\Api\Adapter\Slim\Exception\HttpValidationException;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class FetchStatisticsMiddleware extends AbstractMiddleware
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Request
     */
    public function applyBefore(Request $request, Response $response): Request
    {
        $customerId = $request->getParam("customerID");
        if (false === Validator::intVal()->validate($customerId)) {
            throw new HttpValidationException("Invalid customerID passed");
        }

        $date = $request->getParam("date");

        if (false === Validator::date()->validate($date)) {
            throw new HttpValidationException("Invalid date passed");
        }

        return $request;
    }
}
