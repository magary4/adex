<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Port;

use Adex\Api\Domain\Model\Customer;
use Doctrine\ORM\EntityManager;

class CustomerRepository
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * CustomerRepository constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $customerId
     * @return Customer|null
     */
    public function find(int $customerId): ?Customer
    {
        return $this->em->find(Customer::class, $customerId);
    }
}
