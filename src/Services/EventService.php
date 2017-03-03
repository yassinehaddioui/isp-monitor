<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/25/17
 * Time: 6:28 PM
 */

namespace IspMonitor\Services;


use IspMonitor\Models\Event;
use IspMonitor\Models\EventFilter;
use IspMonitor\Repositories\EventRepository;
use IspMonitor\Repositories\ReservationRepository;

class EventService
{
    /** @var  EventRepository $eventRepo */
    protected $eventRepo;
    /** @var ReservationRepository $reservationRepo */
    protected $reservationRepo;

    const FILTER_PRESET_UPCOMING = 'upcoming';

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

    /**
     * @param EventFilter $filter
     * @return Event[]
     */

    public function getEvents(EventFilter $filter)
    {
        switch ($filter->getPreset()){
            case EventFilter::PRESET_UPCOMING:
                return $this->eventRepo->getUpcomingEvents();
            case EventFilter::PRESET_OPEN:
                return $this->eventRepo->getEventsOpenForRegistration();
            case EventFilter::PRESET_ONGOING:
                return $this->eventRepo->getCurrentAndFutureEvents();
            default:
                return $this->eventRepo->getAll();
        }
    }

    public function getEvent($eventId)
    {
        return $this->eventRepo->findById($eventId);
    }

}