<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Port;

use Adex\Api\Domain\Model\HourlyStat;
use Doctrine\ORM\EntityManager;

class HourlyStatRepository
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
     * @param \DateTime $time
     * @param bool $valid
     * @throws \Exception
     */
    public function update(int $customerId, \DateTime $time, bool $valid = true): void
    {
        $result = $this->em->createQueryBuilder()
            ->select("h")
            ->from(HourlyStat::class, 'h')
            ->where('h.customerId = :customerId')
            ->andWhere('h.time = :time')
            ->setParameter(':customerId', $customerId)
            ->setParameter(':time', $time)
            ->getQuery()
            ->execute();

        if (1 < count($result)) {
            throw new \Exception("More then one record per hour in table 'hourly_stats' for customer_id ".$customerId);
        }

        if (1 === count($result)) {

            /** @var HourlyStat $hourlyStat */
            $hourlyStat = $result[0];

            if ($valid) {
                $hourlyStat->setRequestCount($hourlyStat->getRequestCount()+1);
            } else {
                $hourlyStat->setInvalidCount($hourlyStat->getInvalidCount()+1);
            }
        } else {
            $hourlyStat = new HourlyStat();
            $hourlyStat->setCustomerId($customerId);
            $hourlyStat->setTime($time);

            if ($valid) {
                $hourlyStat->setRequestCount(1);
            } else {
                $hourlyStat->setInvalidCount(1);
            }
        }

        $this->em->persist($hourlyStat);
        $this->em->flush();
    }

    /**
     * @param int $customerId
     * @param \DateTime $date
     * @return mixed
     */
    public function getStatistics(int $customerId, \DateTime $date)
    {
        $result = $this->em->createQueryBuilder()
            ->select("h")
            ->from(HourlyStat::class, 'h')
            ->where('h.customerId = :customerId')
            ->andWhere("h.time > :date_start ")
            ->andWhere("h.time < :date_end ")
            ->setParameter(':customerId', $customerId)
            ->setParameter(':date_start', $date->format('Y-m-d 00:00:00'))
            ->setParameter(':date_end', $date->format('Y-m-d 23:59:59'))
            ->getQuery()
            ->execute();

        return $result;
    }
}
