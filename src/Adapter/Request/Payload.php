<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Request;

class Payload
{
    /**
     * @var int
     */
    private $customerId;

    /**
     * @var int
     */
    private $tagId;

    /**
     * @var int
     */
    private $ip;

    /**
     * @var \DateTime
     */
    private $time;

    /**
     * Payload constructor.
     * @param int $customerId
     * @param int $tagId
     * @param int $ip
     * @param \DateTime $time
     */
    public function __construct(int $customerId, int $tagId, int $ip, \DateTime $time)
    {
        $this->customerId = $customerId;
        $this->tagId      = $tagId;
        $this->ip         = $ip;
        $this->time       = $time;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @return int
     */
    public function getTagId(): int
    {
        return $this->tagId;
    }

    /**
     * @return int
     */
    public function getIp(): int
    {
        return $this->ip;
    }

    /**
     * @return \DateTime
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }
}
