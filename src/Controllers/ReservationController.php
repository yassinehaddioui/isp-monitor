<?php


namespace IspMonitor\Controllers;


use IspMonitor\Services\ReservationService;
use Slim\Http\Request;
use Slim\Http\Response;

class ReservationController extends BaseController
{
    /** @var  ReservationService $reservationService */
    protected $reservationService;

    /**
     * ReservationController constructor.
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function makeReservation(Request $request, Response $response, $args)
    {
        $ipAddress = $request->getAttribute('ip_address');
        $email = $request->getParam('email');
        $eventId = $request->getParam('eventId');
        $browserSignature = $request->getParam('browserSignature');
        $data = $this->reservationService->makeReservation($email, $eventId, $browserSignature, $ipAddress);
        return $this->jsonDataResponse($response, $data);
    }


}