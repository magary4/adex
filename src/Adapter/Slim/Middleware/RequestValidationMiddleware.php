<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Middleware;

use Adex\Api\Adapter\Request\Payload;
use Adex\Api\Adapter\Slim\Exception\HttpValidationException;
use Respect\Validation\Validator;
use Slim\Http\Request;
use Slim\Http\Response;

class RequestValidationMiddleware extends AbstractMiddleware
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Request
     */
    public function applyBefore(Request $request, Response $response): Request
    {
        $data = $request->getBody()->getContents();

        // validate json
        if (false === Validator::json()->validate($data)) {
            throw new HttpValidationException("Invalid request. Valid JSON acceptable");
        }

        $errors = [];

        $payload = json_decode($data);

        if (!isset($payload->customerID) || false === Validator::intVal()->validate($payload->customerID)) {
            $errors["CustomerID"] = 'Invalid customerID';
        }

        if (!isset($payload->tagID) || false === Validator::intVal()->validate($payload->tagID)) {
            $errors["tagID"] = 'Invalid tagID';
        }

        if (!isset($payload->remoteIP) || false === Validator::ip()->validate($payload->remoteIP)) {
            $errors["remoteIP"] = 'Invalid remoteIP';
        }

        if (!isset($payload->timestamp) || false === Validator::intVal()->validate($payload->timestamp)) {
            $errors["timestamp"] = 'Invalid timestamp';
        }

        $time = ($payload->timestamp-($payload->timestamp % 3600));
        $time = (new \DateTime())->setTimestamp($time);

        if (count($errors)) {
            throw new HttpValidationException("Invalid input", $errors);
        }

        $payloadObject = new Payload(
            (int)$payload->customerID,
            (int)$payload->tagID,
            ip2long($payload->remoteIP),
            $time
        );

        $request = $request->withAttribute(Payload::class, $payloadObject);

        return $request;
    }
}
