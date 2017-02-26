<?php


namespace IspMonitor\Providers;

use IspMonitor\Services\ArrayBasedAuthService;
use IspMonitor\Services\CachingService;
use IspMonitor\Services\ErrorHandlingService;
use IspMonitor\Services\MongoDataService;
use IspMonitor\Services\SpeedTestMongoDataService;
use IspMonitor\Services\SpeedTestService;
use Monolog;
use Slim;

use Interop\Container\ContainerInterface;

class ServiceProvider
{
    /**
     * @var array
     */
    private $settings;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ServiceProvider constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->settings = $this->container->get('settings');
    }

    /**
     * @return ContainerInterface
     */

    public function initializeContainer()
    {
        $this->container['renderer'] = function ($c) {
            return $this->getRenderer();
        };

        $this->container['logger'] = function ($c) {
            return $this->getLogger();
        };

        $this->container['speedTestService'] = function ($c) {
            return $this->getSpeedTestService();
        };

        $this->container['authService'] = function ($c) {
            return $this->getAuthService();
        };

        $this->container['errorHandler'] = function ($c) {
            return $this->getErrorHandler();
        };

        $this->container['recordingService'] = function ($c) {
            return $this->getRecordingService();
        };

        $this->container['speedTestRecordingService'] = function ($c) {
            return $this->getSpeedTestRecordingService();
        };

        $this->container['cachingService'] = function ($c) {
            return $this->getCachingService();
        };

        return $this->container;
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

    public function getRecordingService()
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

}