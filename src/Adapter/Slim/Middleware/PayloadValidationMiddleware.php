<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Middleware;

use Adex\Api\Adapter\Port\AdTagRepository;
use Adex\Api\Adapter\Port\CustomerRepository;
use Adex\Api\Adapter\Port\IpBlacklistRepository;
use Adex\Api\Adapter\Request\Payload;
use Adex\Api\Adapter\Slim\Exception\HttpValidationException;
use Adex\Api\Adapter\Slim\Validator;
use Adex\Api\Domain\Model\Customer;
use Slim\Http\Request;
use Slim\Http\Response;

class PayloadValidationMiddleware extends AbstractMiddleware
{
    /**
     * @var AdTagRepository
     */
    private $adTagRepository;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var IpBlacklistRepository
     */
    private $ipBlacklistRepository;

    /**
     * PayloadValidationMiddleware constructor.
     * @param AdTagRepository $adTagRepository
     * @param CustomerRepository $customerRepository
     * @param IpBlacklistRepository $ipBlacklistRepository
     */
    public function __construct(
        AdTagRepository $adTagRepository,
        CustomerRepository $customerRepository,
        IpBlacklistRepository $ipBlacklistRepository
    ) {
        $this->adTagRepository       = $adTagRepository;
        $this->customerRepository    = $customerRepository;
        $this->ipBlacklistRepository = $ipBlacklistRepository;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Request
     */
    public function applyBefore(Request $request, Response $response): Request
    {
        /** @var Payload $payload */
        $payload = $request->getAttribute(Payload::class);

        $inBlacklist = $this->ipBlacklistRepository->findIp($payload->getIp());

        $errors = [];

        if (null !== $inBlacklist) {
            throw new HttpValidationException("Ip in blacklist");
        }

        /** @var Customer $customer */
        $customer = $this->customerRepository->find($payload->getCustomerId());

        if (null === $customer) {
            throw new HttpValidationException("Customer with passed Id not found");
        }

        if (false === $customer->getActive()) {
            throw new HttpValidationException("Customer is not active");
        }

        $adTag = $this->adTagRepository->find($payload->getTagId());

        if (null === $adTag) {
            throw new HttpValidationException("AdTag with passed Id not found");
        }

        if (false === $adTag->getActive()) {
            throw new HttpValidationException("AdTag is not active");
        }

        if ($payload->getCustomerId() !== $adTag->getCustomerId()) {
            throw new HttpValidationException("AdTag belongs to another customer");
        }

        return $request;
    }
}
