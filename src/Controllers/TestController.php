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
use IspMonitor\Repositories\EventRepository;
use IspMonitor\Repositories\ReservationRepository;
use IspMonitor\Services\RedLockService;
use IspMonitor\Services\ReservationService;

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
        $ipAddress = $request->getAttribute('ip_address');
        /**
         * @var MongoDataService
         */
        $MongoDataService = $this->container->get('dataService');
        $eventRepo = new EventRepository($MongoDataService);
        $cachingService = $this->container->get('cachingService');
        $reservationRepo = new ReservationRepository($MongoDataService);
        $redLockService = new RedLockService([['isp-monitor-redis', 6379, 0.01]]);
        $reservationService = new ReservationService($eventRepo, $reservationRepo, $redLockService, $cachingService);
        $data = $reservationService->makeReservation(uniqid() . '@hadds.com', 'ev58b2653bd2abe', 'signature', $ipAddress);
//        $data = $reservationService->checkAvailability('ev58b2653bd2abe');
        return $this->jsonDataResponse($response, $data);
    }

}