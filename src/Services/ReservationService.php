<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/26/17
 * Time: 12:24 AM
 */

namespace IspMonitor\Services;


use IspMonitor\Exceptions\EventClosedException;
use IspMonitor\Exceptions\ReservationAlreadyMadeException;
use IspMonitor\Models\AvailabilityResponse;
use IspMonitor\Models\Event;
use IspMonitor\Models\Reservation;
use IspMonitor\Repositories\EventRepository;
use IspMonitor\Repositories\ReservationRepository;
use Sumeko\Http\Exception\NotFoundException;

class ReservationService
{
    /**
     * @var EventRepository $eventRepo
     */
    protected $eventRepo;
    /**
     * @var ReservationRepository $reservationRepo
     */
    protected $reservationRepo;

    /**
     * @var RedLockService
     */
    protected $redLockService;

    /** @var  CachingService $cachingService */
    protected $cachingService;

    const RESOURCE_NAME = 'reservation';
    const LOCK_TTL = 500;
    const AVAILABILITY_CACHE_TTL = 60;

    /**
     * ReservationService constructor.
     * @param EventRepository $eventRepo
     * @param ReservationRepository $reservationRepo
     * @param RedLockService $redLockService
     * @param CachingService $cachingService
     */
    public function __construct(EventRepository $eventRepo,
                                ReservationRepository $reservationRepo, RedLockService $redLockService = null,
                                CachingService $cachingService = null)
    {
        $this->eventRepo = $eventRepo;
        $this->reservationRepo = $reservationRepo;
        $this->redLockService = $redLockService;
        $this->cachingService = $cachingService;
    }

    /**
     * This will check if the event is still open and make a reservation if possible.
     *
     * @param string $email
     * @param string $eventId
     * @param string $browserSignature
     * @param string $ipAddress
     * @return Reservation
     * @throws \Exception
     */

    public function makeReservation($email, $eventId, $browserSignature = '', $ipAddress = '')
    {
        /* Check if the event is still open for reservation */
        $available = $this->checkAvailability($eventId);
        if (!$available->isOpen())
            throw new EventClosedException();

        /* Try to acquire a lock on the event */
        $resourceLockLey = static::RESOURCE_NAME . '_' . $eventId;
        $lock = $this->redLockService->lock($resourceLockLey, static::LOCK_TTL);

        try {
            /*  Check again now that you acquired the lock. In case someone made a reservation. */
            $available = $this->checkAvailability($eventId);
            if (!$available->isOpen())
                throw new EventClosedException();

            /* Check if your email isn't already registered for the event . */
            $existing = $this->reservationRepo->findByEmailAndEventId($email, $eventId);
            if (count($existing) > 0)
                throw new ReservationAlreadyMadeException();

            /* Make a reservation */
            $reservation = new Reservation([
                'email' => $email,
                'eventId' => $eventId,
                'browserSignature' => $browserSignature,
                'ipAddress' => $ipAddress]);
            $reservation = $this->reservationRepo->save($reservation);

            /* Unlock the reservations for the event. */
            $this->redLockService->unlock($lock);

            return $reservation;

        } catch (\Exception $e) {
            /* If something goes wrong, we want to unlock the event regardless. */
            $this->redLockService->unlock($lock);
            /* Then we let things go wrong. */
            throw $e;
        }
    }

    /**
     * Checks if an event is open for reservation.
     *
     * @param $eventId
     * @return AvailabilityResponse
     * @throws NotFoundException
     */

    public function checkAvailability($eventId)
    {
        /* Check the cache and returned cached data if available. */
        $cacheKey = self::RESOURCE_NAME . '__availability_' . $eventId;
        $availability = $this->cachingService->get($cacheKey);
        if (!empty($availability) && ($availability instanceof AvailabilityResponse))
            return $availability;

        /* Otherwise, pull fresh data */
        $event = $this->eventRepo->findById($eventId);
        if (!$event)
            throw new NotFoundException('Event not found.');
        $reservations = $this->reservationRepo->findByEventId($eventId);
        $reservationsCount = count($reservations);

        /* Check for capacity */
        $open = (!$event->getMaximumCapacity() || $event->getMaximumCapacity() > $reservationsCount);

        /* Check for expiration */
        if (($event->getRegistrationDateEnd() && $event->getRegistrationDateEnd() < time()) || $event->getDateEnd() < time())
            $open = false;

        /* Check if registration is open yet */
        if ($event->getRegistrationDateStart() && $event->getRegistrationDateStart() > time())
            $open = false;

        /* Don't expose reservations data if not needed */
        if (!$event->isExposeReservations())
            $reservations = [];

        /* Prepare response */
        $response = new AvailabilityResponse($event, $reservations, $reservationsCount, $open);

        /* Cache it if event is not open for reservation */
        if (!$open)
            $this->cachingService->set($cacheKey, $response, static::AVAILABILITY_CACHE_TTL);

        return $response;
    }
}