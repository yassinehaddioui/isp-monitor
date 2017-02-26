<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/26/17
 * Time: 1:38 AM
 */

namespace IspMonitor\Controllers;

use Interop\Container\ContainerInterface;
use IspMonitor\Services\MongoDataService;
use Slim\Http\Request;
use Slim\Http\Response;

class TestController extends BaseController
{
    /**
     * TestController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function getTest(Request $request, Response $response, $args)
    {
        /**
         * @var MongoDataService
         */
        $MongoDataService = $this->container->get('dataService');
        $eventRepo = new \IspMonitor\Repositories\EventRepository($MongoDataService);
        $cachingService = $this->container->get('cachingService');
        $reservationRepo = new \IspMonitor\Repositories\ReservationRepository($MongoDataService);
        $redLockService = new \IspMonitor\Services\RedLockService([['isp-monitor-redis', 6379, 0.01]]);
        $reservationService = new \IspMonitor\Services\ReservationService($eventRepo, $reservationRepo, $redLockService, $cachingService);
        $reservation = $reservationService->makeReservation(uniqid() . '@hadds.com', 'ev58b2653bd2abe');
        return $this->jsonDataResponse($response, $reservation);
    }

}