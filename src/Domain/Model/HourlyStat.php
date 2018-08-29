<?php declare(strict_types=1);

namespace Adex\Api\Domain\Model;

class HourlyStat
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $customerId;

    /**
     * @var \DateTime
     */
    private $time;

    /**
     * @var int
     */
    private $requestCount=0;

    /**
     * @var int
     */
    private $invalidCount=0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     */
    public function setCustomerId(int $customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     */
    public function setTime(\DateTime $time)
    {
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getRequestCount()
    {
        return $this->requestCount;
    }

    /**
     * @param int $requestCount
     */
    public function setRequestCount(int $requestCount)
    {
        $this->requestCount = $requestCount;
    }

    /**
     * @return int
     */
    public function getInvalidCount()
    {
        return $this->invalidCount;
    }

    /**
     * @param int $invalidCount
     */
    public function setInvalidCount(int $invalidCount)
    {
        $this->invalidCount = $invalidCount;
    }
}
