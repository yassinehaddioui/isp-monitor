<?php


namespace IspMonitor\Services;

use IspMonitor\Exceptions\EventClosedException;
use IspMonitor\Exceptions\ReservationAlreadyMadeException;
use IspMonitor\Exceptions\UnableToAcquireLockException;
use IspMonitor\Models\AvailabilityResponse;
use IspMonitor\Models\Reservation;
use IspMonitor\Repositories\EventRepository;
use IspMonitor\Repositories\ReservationRepository;
use RandomLib\Factory;
use SecurityLib\Strength;
use Sumeko\Http\Exception\BadRequestException;
use Sumeko\Http\Exception\FailedDependencyException;
use Sumeko\Http\Exception\NotFoundException;

class ReservationService
{
    const CONFIRMATION_CODE_PREFIX = '';
    const CONFIRMATION_CODE_LENGTH = 16;
    const CONFIRMATION_CODE_CHARSET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

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

    /** @var  Factory */
    protected $randomGeneratorFactory;


    const RESOURCE_NAME = 'reservation';
    const LOCK_TTL = 500;
    const AVAILABILITY_CACHE_TTL = 60;

    /**
     * ReservationService constructor.
     * @param EventRepository $eventRepo
     * @param ReservationRepository $reservationRepo
     * @param RedLockService $redLockService
     * @param CachingService $cachingService
     * @param Factory $randomGeneratorFactory
     */
    public function __construct(EventRepository $eventRepo,
                                ReservationRepository $reservationRepo,
                                RedLockService $redLockService = null,
                                CachingService $cachingService = null,
                                Factory $randomGeneratorFactory = null)
    {
        $this->eventRepo = $eventRepo;
        $this->reservationRepo = $reservationRepo;
        $this->redLockService = $redLockService;
        $this->cachingService = $cachingService;
        $this->randomGeneratorFactory = $randomGeneratorFactory;
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
        if (!$email || !$eventId)
            throw new BadRequestException('Email and Event ID are required.');
        if (!$this->redLockService || !$this->cachingService)
            throw new FailedDependencyException('Missing RedLockService and/or Caching Service.');

        /* Check if the event is still open for reservation */
        $available = $this->checkAvailability($eventId);
        if (!$available->isOpen())
            throw new EventClosedException();

        /* Try to acquire a lock on the event */
        $resourceLockLey = static::RESOURCE_NAME . '_' . $eventId;
        $lock = $this->redLockService->lock($resourceLockLey, static::LOCK_TTL);
        if (!$lock)
            throw new UnableToAcquireLockException();

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
                'ipAddress' => $ipAddress,
                'confirmationCode' => $this->generateConfirmationCode()]);
            $reservation = $this->reservationRepo->save($reservation);
            $reservationCount = $this->reservationRepo->countReservationsInEvent($eventId);
            $event = $this->eventRepo->findById($eventId);
            $event->setReservationCount($reservationCount);
            $this->eventRepo->save($event);
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
        $reservationsCount = $event->getReservationCount();

        /* Check for capacity */
        $open = (!$event->getMaximumCapacity() || $event->getMaximumCapacity() > $reservationsCount);

        /* Check for expiration */
        if (($event->getRegistrationDateEnd() && $event->getRegistrationDateEnd() < time()) || $event->getDateEnd() < time())
            $open = false;

        /* Check if registration is open yet */
        if ($event->getRegistrationDateStart() && $event->getRegistrationDateStart() > time())
            $open = false;

        $reservations = $event->isExposeReservations() ? $this->reservationRepo->findByEventId($eventId) : [];

        /* Prepare response */
        $response = new AvailabilityResponse($event, $reservations, $reservationsCount, $open);

        /* Cache it if event is not open for reservation */
        if (!$open)
            $this->cachingService->set($cacheKey, $response, static::AVAILABILITY_CACHE_TTL);

        return $response;
    }

    /**
     * Generates a random confirmation code.
     * @param int $length
     * @return string
     * @throws FailedDependencyException
     */
    protected function generateConfirmationCode($length = self::CONFIRMATION_CODE_LENGTH)
    {
        if (!$this->randomGeneratorFactory)
            throw new FailedDependencyException('Missing Random Generator Factory.');

        $generator = $this->randomGeneratorFactory->getGenerator(new Strength(Strength::LOW));
        return $generator->generateString($length, static::CONFIRMATION_CODE_CHARSET);
    }
}