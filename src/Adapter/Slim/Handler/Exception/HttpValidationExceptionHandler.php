<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Handler\Exception;

use Adex\Api\Adapter\Port\HourlyStatRepository;
use Adex\Api\Adapter\Slim\Exception\HttpValidationException;
use Adex\Api\Domain\Model\HourlyStat;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Slim\Handlers\Error;

class HttpValidationExceptionHandler
{
    /** @var ContainerInterface */
    private $container;

    /**
     * HttpValidationExceptionHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, Exception $exception)
    {
        if ($exception instanceof HttpValidationException) {
            $customerId = $request->getParsedBodyParam("customerID");
            $timestamp = $request->getParsedBodyParam("timestamp");

            if ($customerId && $timestamp) {
                // round to nearest hour
                $time = ( new \DateTime() )->setTimestamp($timestamp - ( $timestamp % 3600 ));

                try {
                    $this->getHourlyStatRepository()->update( $customerId, $time, false );
                } catch (\Exception $e) {
                    // do nothing
                }
            }

            $json = json_encode([
                'message'             => 'Validation exception: '. $exception->getMessage(),
                'validation_messages' => $exception->getExtra(),
            ]);
            if (false === is_string($json)) {
                $json = '{message: "Unexpected exception. (456)"}';
            }

            return $response->withStatus(500)
                ->withHeader('Content-Type', 'json')
                ->write($json);
        }

        return $this->getSlimDefaultErrorResponse($request, $response, $exception);
    }

    private function getSlimDefaultErrorResponse(
        Request $request,
        Response $response,
        Exception $exception
    ) {
        $defaultError = new Error(
            $this->container->get('settings')['displayErrorDetails']
        );

        return $defaultError($request, $response, $exception);
    }

    private function getHourlyStatRepository(): HourlyStatRepository
    {
        return $this->container->get(HourlyStatRepository::class);
    }
}
