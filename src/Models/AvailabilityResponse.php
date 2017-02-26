<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/26/17
 * Time: 12:30 AM
 */

namespace IspMonitor\Models;


use IspMonitor\Models\Base\BaseSerializableModel;

class AvailabilityResponse extends BaseSerializableModel
{
    /**
     * @var Event
     */
    protected $event;
    /**
     * @var Reservation[]
     */
    protected $reservations;
    /**
     * @var int
     */
    protected $reservationCount = 0;
    /**
     * @var bool
     */
    protected $open = false;

    /**
     * AvailabilityResponse constructor.
     * @param Event $event
     * @param Reservation[] $reservations
     * @param int $reservationCount
     * @param bool $open
     */
    public function __construct(Event $event, array $reservations, $reservationCount, $open)
    {
        $this->event = $event;
        $this->reservations = $reservations;
        $this->reservationCount = $reservationCount;
        $this->open = $open;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return Reservation[]
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @return int
     */
    public function getReservationCount()
    {
        return $this->reservationCount;
    }

    /**
     * @return bool
     */
    public function isOpen()
    {
        return $this->open;
    }

}