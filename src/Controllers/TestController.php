<?php

namespace IspMonitor\Controllers;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
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
         * @var ReservationService
         */
        $reservationService = $this->container->get('reservationService');
        $data = $reservationService->makeReservation(uniqid() . '@hadds.com', 'ev58b2653bd2abe', 'signature', $ipAddress);
//        $data = $reservationService->checkAvailability('ev58b2653bd2abe');
        return $this->jsonDataResponse($response, $data);
    }

}