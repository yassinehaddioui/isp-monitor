<?php


namespace IspMonitor\Providers;

use IspMonitor\Services\AuthService;
use IspMonitor\Services\ErrorHandlingService;
use IspMonitor\Services\SpeedTestService;
use Monolog;
use Slim;

use Interop\Container\ContainerInterface;

class ServiceProvider
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ServiceProvider constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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

        return $this->container;
    }

    public function getRenderer()
    {
        $settings = $this->container->get('settings')['renderer'];
        return new Slim\Views\PhpRenderer($settings['template_path']);
    }

    public function getLogger()
    {
        $settings = $this->container->get('settings')['logger'];
        $logger = new Monolog\Logger($settings['name']);
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    }

    public function getSpeedTestService()
    {
        $settings = $this->container->get('settings')['speedTestService'];
        return new SpeedTestService($settings['timeout'], $settings['testUrl']);
    }

    public function getAuthService()
    {
        $settings = $this->container->get('settings')['authService'];
        return new AuthService($settings['apiKey']);
    }

    public function getErrorHandler()
    {
        return new ErrorHandlingService();
    }

}