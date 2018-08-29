<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim;

use Adex\Api\Adapter\Request\Payload;
use Adex\Api\Adapter\Slim\Action\StatisticsAction;
use Adex\Api\Adapter\Slim\Middleware\FetchStatisticsMiddleware;
use Adex\Api\Adapter\Slim\Middleware\PayloadValidationMiddleware;
use Adex\Api\Adapter\Slim\Middleware\RequestValidationMiddleware;
use Slim\App;
use Adex\Api\Adapter\Slim\Action\IncomingRequestAction;

class Routes
{
    /** @var App  */
    private $app;

    /**
     * Routes constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function bootstrap(): void
    {
        $app = $this->app;
        $router = $this;

        $app
            ->post("/incoming-request", function ($request, $response, $args) use ($app) {
                $app->getContainer()->get(IncomingRequestAction::class)->exec(
                    $request->getAttribute(Payload::class),
                    $response
                );
            })
            ->add(PayloadValidationMiddleware::class)
            ->add(RequestValidationMiddleware::class);

        // TODO: grunt this route
        $app
            ->get("/statistics", function ($request, $response, $args) use ($app) {
                $app->getContainer()->get(StatisticsAction::class)->exec(
                    intval($request->getParam("customerID")),
                    new \DateTime($request->getParam("date")),
                    $response
                );
            })
            ->add(FetchStatisticsMiddleware::class)
        ;
    }
}
