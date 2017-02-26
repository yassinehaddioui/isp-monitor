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
    const AVAILABILITY_CACHE_TTL = 10;

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
     * @param string $email
     * @param string $eventId
     * @param string $browserSignature
     * @param string $ipAddress
     * @return Reservation
     * @throws \Exception
     */

    public function makeReservation($email, $eventId, $browserSignature = '', $ipAddress = '')
    {
        $resourceLockLey = static::RESOURCE_NAME . '_' . $eventId;
        $available = $this->checkAvailability($eventId);
        if (!$available->isOpen())
            throw new EventClosedException();
        $lock = $this->redLockService->lock($resourceLockLey, static::LOCK_TTL);
        try {
            /**  Check again now that you acquired the lock. In case someone made a reservation. */
            $available = $this->checkAvailability($eventId);
            if (!$available->isOpen())
                throw new EventClosedException();
            $existing = $this->reservationRepo->findByEmailAndEventId($email, $eventId);
            if (count($existing) > 0)
                throw new ReservationAlreadyMadeException();
            $reservation = new Reservation([
                'email' => $email,
                'eventId' => $eventId,
                'browserSignature' => $browserSignature,
                'ipAddress' => $ipAddress]);
            $reservation = $this->reservationRepo->save($reservation);
            $this->redLockService->unlock($lock);
            return $reservation;

        } catch (\Exception $e) {
            $this->redLockService->unlock($lock);
            throw $e;
        }
    }

    /**
     * @param $eventId
     * @return AvailabilityResponse
     * @throws NotFoundException
     */

    public function checkAvailability($eventId)
    {
        $cacheKey = self::RESOURCE_NAME . '__availability_' . $eventId;
        $availability = $this->cachingService->get($cacheKey);
        if (!empty($availability) && ($availability instanceof  AvailabilityResponse))
            return $availability;
        $event = $this->eventRepo->findById($eventId);
        if (!$event)
            throw new NotFoundException('Event not found.');
        $reservations = $this->reservationRepo->findByEventId($eventId);
        $reservationsCount = count($reservations);
        $open = (!$event->getMaximumCapacity() || $event->getMaximumCapacity() > $reservationsCount);
        if ($event->getRegistrationDateEnd() && $event->getRegistrationDateEnd() < time())
            $open = false;
        if ($event->getDateEnd() < time())
            $open = false;
        if (!$event->isExposeReservations())
            $reservations = [];
        $response = new AvailabilityResponse($event, $reservations, $reservationsCount, $open);
        if (!$open)
            $this->cachingService->set($cacheKey, $response, static::AVAILABILITY_CACHE_TTL);
        return $response;
    }
}