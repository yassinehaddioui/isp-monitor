<?php


namespace IspMonitor\Repositories;


use IspMonitor\Exceptions\SaveFailedException;
use IspMonitor\Models\Event;
use MongoDB\Driver\Cursor;

class EventRepository extends BaseRepository
{


    const COLLECTION_NAME = 'events';
    const DB_NAME = 'reservation-service';
    const ID_PREFIX = '';

    /**
     * @return Event[]
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * Get all events that haven't ended yet.
     * @return Event[]
     */

    public function getCurrentAndFutureEvents()
    {
        $filter = [
            'dateEnd' => ['$gte' => time()],
        ];
        return $this->normalize($this->getCollection()->find($filter));
    }

    /**
     * Get all events where registration is open.
     * @return Event[]
     */

    public function getEventsOpenForRegistration()
    {
        $filter = [
            'registrationDateEnd' => ['$gt' => time()],
            'registrationDateStart' => ['$lte' => time()],
        ];
        return $this->normalize($this->getCollection()->find($filter));
    }

    /**
     * Get all events that haven't started yet.
     * @return Event[]
     */

    public function getUpcomingEvents()
    {
        $filter = [
            'dateStart' => ['$gt' => time()],
        ];
        return $this->normalize($this->getCollection()->find($filter));
    }

    /**
     * @param Event $event
     * @return Event
     */
    protected function prepareEvent(Event $event)
    {
        if (!$event->getId())
            $event->setId(uniqid(static::ID_PREFIX));
        if (!$event->getDateCreated())
            $event->setDateCreated(time());
        if (!$event->getRegistrationDateStart())
            $event->setRegistrationDateStart(time());
        if (!$event->getRegistrationDateEnd())
            $event->setRegistrationDateEnd($event->getDateEnd());
        $event->setLastUpdate(time());
        $event->validate();
        return $event;
    }

    /**
     * @param Event $event
     * @return Event
     * @throws SaveFailedException
     */
    public function save(Event $event)
    {
        $event = $this->prepareEvent($event);
        $result = $this->getCollection()->replaceOne(
            ['_id' => $event->getId()],
            $event,
            ['upsert' => true]);
        if (!$result->getUpsertedCount() && !$result->getModifiedCount())
            throw new SaveFailedException();
        return $event;
    }


    /**
     * @param Cursor $entities
     * @return Event[]
     */

    protected function normalize($entities)
    {
        $result = [];
        foreach ($entities as $entity) {
            $result[] = new Event($entity);
        }
        return $result;
    }

}