<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/25/17
 * Time: 9:46 PM
 */

namespace IspMonitor\Repositories;

use IspMonitor\Models\Reservation;
use IspMonitor\Exceptions\SaveFailedException;
use MongoDB\Driver\Cursor;

class ReservationRepository extends BaseRepository
{
    const COLLECTION_NAME = 'reservations';
    const DB_NAME = 'reservation-service';
    const ID_PREFIX = '';


    /**
     * @return Reservation[]
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * @param $eventId
     * @return Reservation[]
     */
    public function findByEventId($eventId)
    {
        return $this->normalize($this->getCollection()->find(['eventId' => $eventId]));
    }

    /**
     * @param $email
     * @return Reservation[]
     */
    public function findByEmail($email)
    {
        return $this->normalize($this->getCollection()->find(['email' => $email]));
    }

    /**
     * @param string $email
     * @param string $eventId
     * @return Reservation[]
     */
    public function findByEmailAndEventId($email, $eventId)
    {
        return $this->normalize($this->getCollection()->find(['email' => $email, 'eventId' => $eventId]));
    }

    /**
     * @param Reservation $reservation
     * @return Reservation
     */
    protected function prepareReservation(Reservation $reservation)
    {
        if (!$reservation->getId())
            $reservation->setId(uniqid(static::ID_PREFIX));
        if (!$reservation->getDateCreated())
            $reservation->setDateCreated(time());
        $reservation->validate();
        return $reservation;
    }

    /**
     * @param $eventId
     * @return int
     */
    public function countReservationsInEvent($eventId)
    {
        return $this->getCollection()->count(['eventId' => $eventId]);
    }

    /**
     * @param Reservation $reservation
     * @return Reservation
     * @throws SaveFailedException
     */
    public function save(Reservation $reservation)
    {
        $reservation = $this->prepareReservation($reservation);
        $result = $this->getCollection()->replaceOne(
            ['_id' => $reservation->getId()],
            $reservation,
            ['upsert' => true]);
        if (!$result->getUpsertedCount() && !$result->getModifiedCount())
            throw new SaveFailedException('Nothing was saved. Maybe no changes were necessary.');
        return $reservation;
    }

    /**
     * @param Cursor $entities
     * @return Reservation[]
     */

    protected function normalize($entities)
    {
        $result = [];
        foreach ($entities as $entity) {
            $result[] = new Reservation($entity);
        }
        return $result;
    }

}