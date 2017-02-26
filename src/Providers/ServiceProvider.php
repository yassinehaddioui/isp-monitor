<?php


namespace IspMonitor\Providers;

use IspMonitor\Repositories\EventRepository;
use IspMonitor\Repositories\ReservationRepository;
use IspMonitor\Services\ArrayBasedAuthService;
use IspMonitor\Services\CachingService;
use IspMonitor\Services\ErrorHandlingService;
use IspMonitor\Services\MongoDataService;
use IspMonitor\Services\RedLockService;
use IspMonitor\Services\ReservationService;
use IspMonitor\Services\SpeedTestMongoDataService;
use IspMonitor\Services\SpeedTestService;
use Monolog;
use RandomLib\Factory;
use Slim;


class ServiceProvider
{
    /**
     * @var array
     */
    private $settings;

    /**
     * ServiceProvider constructor.
     * @param array $settings
     */
    public function __construct($settings)
    {
        $this->settings = $settings;
    }


    /**
     * @return Slim\Views\PhpRenderer
     */

    public function getRenderer()
    {
        $settings = $this->settings['renderer'];
        return new Slim\Views\PhpRenderer($settings['template_path']);
    }

    /**
     * @return Monolog\Logger
     */

    public function getLogger()
    {
        $settings = $this->settings['logger'];
        $logger = new Monolog\Logger($settings['name']);
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    }

    /**
     * @return SpeedTestService
     */

    public function getSpeedTestService()
    {
        $settings = $this->settings['speedTestService'];
        return new SpeedTestService($settings['timeout'], $settings['testUrl']);
    }

    /**
     * @return ArrayBasedAuthService
     */

    public function getAuthService()
    {
        $settings = $this->settings['authService'];
        return new ArrayBasedAuthService($settings['apiKeys']);
    }

    /**
     * @return ErrorHandlingService
     */

    public function getErrorHandler()
    {
        return new ErrorHandlingService();
    }

    /**
     * @return MongoDBDataProvider
     */

    public function getMongoDBDataProvider()
    {
        $settings = !empty($this->settings['mongoDB']['connectionString'])
            ? $this->settings['mongoDB']['connectionString'] : null;
        return new MongoDBDataProvider($settings);
    }

    /**
     * @return MongoDataService
     */

    public function getMongoDataService()
    {
        return new MongoDataService($this->getMongoDBDataProvider());
    }

    /**
     * @return SpeedTestMongoDataService
     */

    public function getSpeedTestRecordingService()
    {
        return new SpeedTestMongoDataService($this->getMongoDBDataProvider());
    }

    /**
     * @return RedisCacheProvider
     */

    public function getRedisCacheProvider()
    {
        $settings = !empty($this->settings['redis'])
            ? $this->settings['redis'] : null;
        return new RedisCacheProvider($settings);
    }

    /**
     * @return CachingService
     */
    public function getCachingService()
    {
        return new CachingService($this->getRedisCacheProvider());
    }

    /**
     * @return EventRepository
     */
    public function getEventRepository()
    {
        return new EventRepository($this->getMongoDataService());
    }

    /**
     * @return ReservationRepository
     */

    public function getReservationRepository()
    {
        return new ReservationRepository($this->getMongoDataService());
    }

    /**
     * @return RedLockService
     */

    public function getRedLockService()
    {
        return new RedLockService(
            $this->settings['redLockService']['servers'],
            $this->settings['redLockService']['retryDelay'],
            $this->settings['redLockService']['retryCount']);
    }

    /**
     * @return Factory
     */

    public function getRandomGeneratorFactory()
    {
        return new Factory();
    }

    /**
     * @return ReservationService
     */

    public function getReservationService()
    {
        return new ReservationService(
            $this->getEventRepository(),
            $this->getReservationRepository(),
            $this->getRedLockService(),
            $this->getCachingService(),
            $this->getRandomGeneratorFactory());
    }

}