<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/25/17
 * Time: 6:28 PM
 */

namespace IspMonitor\Services;


use IspMonitor\Repositories\EventRepository;
use IspMonitor\Repositories\ReservationRepository;

class EventService
{
    /** @var  EventRepository $eventRepo */
    protected $eventRepo;
    /** @var ReservationRepository $reservationRepo */
    protected $reservationRepo;

    /**
     * EventService constructor.
     * @param EventRepository $eventRepo
     * @param ReservationRepository $reservationRepo
     */
    public function __construct(EventRepository $eventRepo, ReservationRepository $reservationRepo)
    {
        $this->eventRepo = $eventRepo;
        $this->reservationRepo = $reservationRepo;
    }

    public function getEvents($filters)
    {

    }

}