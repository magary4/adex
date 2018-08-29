<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Port;

use Adex\Api\Domain\Model\IpBlacklist;
use Doctrine\ORM\EntityManager;

class IpBlacklistRepository
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
     * @param int $ip
     * @return IpBlacklist|null
     */
    public function findIp(int $ip): ?IpBlacklist
    {
        return $this->em->find(IpBlacklist::class, $ip);
    }
}
