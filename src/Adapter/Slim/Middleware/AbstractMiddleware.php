<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

abstract class AbstractMiddleware
{
    /**
     * @param Request $request
     * @param Response $response
     * @param mixed $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next): Response
    {
        $request = $this->applyBefore($request, $response);
        $response = $next($request, $response);
        $response = $this->applyAfter($request, $response);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Request
     *
     * @suppress PhanUnusedProtectedMethodParameter
     */
    protected function applyBefore(Request $request, Response $response): Request
    {
        return $request;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     *
     * @suppress PhanUnusedProtectedMethodParameter
     */
    protected function applyAfter(Request $request, Response $response): Response
    {
        return $response;
    }
}
