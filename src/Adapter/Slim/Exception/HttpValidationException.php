<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim\Exception;

class HttpValidationException extends \Exception
{
    private $extra = [];

    /**
     * HttpValidationException constructor.
     * @param string $message
     * @param array $extra
     */
    public function __construct(string $message = '', array $extra = [])
    {
        parent::__construct($message);

        $this->extra = $extra;
    }

    public function getExtra(): array
    {
        return $this->extra;
    }
}
