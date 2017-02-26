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
     * @param Event $event
     * @return Event
     */
    protected function prepareEvent(Event $event)
    {
        if (!$event->getId())
            $event->setId(uniqid(static::ID_PREFIX, true));
        if (!$event->getDateCreated())
            $event->setDateCreated(time());
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
     * @return array
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