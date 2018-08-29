<?php declare(strict_types=1);

namespace Adex\Api\Domain\Model;

class IpBlacklist
{
    /**
     * @var integer;
     */
    private $ip;

    /**
     * @return int
     */
    public function getIp(): int
    {
        return $this->ip;
    }

    /**
     * @param int $ip
     */
    public function setIp(int $ip)
    {
        $this->ip = $ip;
    }
}
