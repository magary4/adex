<?php declare(strict_types=1);

namespace Adex\Api\Adapter\Slim;

use Adex\Api\Adapter\Port\AdTagRepository;
use Adex\Api\Adapter\Port\CustomerRepository;
use Adex\Api\Adapter\Port\HourlyStatRepository;
use Adex\Api\Adapter\Port\IpBlacklistRepository;
use Adex\Api\Adapter\Slim\Action\StatisticsAction;
use Adex\Api\Adapter\Slim\Middleware\FetchStatisticsMiddleware;
use Adex\Api\Adapter\Slim\Middleware\IncomingRequestMiddleware;
use Adex\Api\Adapter\Slim\Middleware\PayloadValidationMiddleware;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Persistence\Mapping\Driver\PHPDriver;
use Psr\Container\ContainerInterface;
use Slim\Container;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Adex\Api\Adapter\Slim\Action\IncomingRequestAction;
use Adex\Api\Adapter\Slim\Middleware\IpBlacklistMiddleware;
use Adex\Api\Adapter\Slim\Handler\Exception\HttpValidationExceptionHandler;

class DIC
{
    /** @var ContainerInterface  */
    private $container;

    /**
     * DIC constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function bootstrap(): void
    {
        $this->initDoctrine();
        $this->initServices();
        $this->addErrorhandler();
    }

    public function bootstrapDoctrine(): void
    {
        $this->initDoctrine();
    }

    protected function initDoctrine(): void
    {
        $this->setService(EntityManager::class, function (Container $c): EntityManager {
            $cache = $c['settings']['doctrine']['entity_dev_mode']
                ? new ArrayCache()
                : new FilesystemCache($c['settings']['doctrine']['cache_dir'])
            ;

            $config = Setup::createConfiguration(
                $c['settings']['doctrine']['dev_mode'],
                $c['settings']['doctrine']['proxy_dir'],
                $cache
            );

            $config->setMetadataDriverImpl(
                new PHPDriver($c['settings']['doctrine']['php_metadata_dirs'])
            );

            return EntityManager::create(
                $c['settings']['doctrine']['connection'],
                $config
            );
        });
    }

    protected function initServices(): void
    {
        $this->setService(IncomingRequestAction::class, function (Container $c): IncomingRequestAction {
            return new IncomingRequestAction($c->get(HourlyStatRepository::class));
        });

        $this->setService(HourlyStatRepository::class, function (Container $c): HourlyStatRepository {
            return new HourlyStatRepository($c->get(EntityManager::class));
        });

        $this->setService(PayloadValidationMiddleware::class, function (Container $c): PayloadValidationMiddleware {
            return new PayloadValidationMiddleware(
                $c->get(AdTagRepository::class),
                $c->get(CustomerRepository::class),
                $c->get(IpBlacklistRepository::class)
            );
        });

        $this->setService(IpBlacklistRepository::class, function (Container $c): IpBlacklistRepository {
            return new IpBlacklistRepository($c->get(EntityManager::class));
        });

        $this->setService(AdTagRepository::class, function (Container $c): AdTagRepository {
            return new AdTagRepository($c->get(EntityManager::class));
        });

        $this->setService(CustomerRepository::class, function (Container $c): CustomerRepository {
            return new CustomerRepository($c->get(EntityManager::class));
        });

        $this->setService(StatisticsAction::class, function (Container $c): StatisticsAction {
            return new StatisticsAction($c->get(HourlyStatRepository::class));
        });
    }

    protected function addErrorhandler(): void
    {
        $this->setService('errorHandler', function (Container $c): HttpValidationExceptionHandler {
            return new HttpValidationExceptionHandler($c);
        });
    }

    /**
     * @param string $id
     * @return object
     */
    protected function getService(string $id): object // 7.2 return type
    {
        return $this->container->get($id);
    }

    /**
     * @param string $id
     * @param mixed $value
     */
    protected function setService(string $id, $value): void
    {
        $this->container[$id] = $value;
    }
}
