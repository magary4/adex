<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Port;

use Adex\Api\Domain\Model\AdTag;
use Adex\Api\Domain\Model\Customer;
use Doctrine\ORM\EntityManager;

class AdTagRepository
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
     * @param int $id
     * @return AdTag|null
     */
    public function find(int $id): ?AdTag
    {
        return $this->em->find(AdTag::class, $id);
    }
}
