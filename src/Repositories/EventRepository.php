<?php


namespace IspMonitor\Repositories;


use IspMonitor\Exceptions\SaveFailedException;
use IspMonitor\Models\Event;
use IspMonitor\Services\MongoDataService;
use MongoDB\Driver\Cursor;

class EventRepository
{
    /**
     * @var MongoDataService
     */
    protected $dataService;

    const COLLECTION_NAME = 'events';
    const DB_NAME = 'reservation-service';
    const ID_PREFIX = 'ev';


    /**
     * EventRepository constructor.
     * @param MongoDataService $dataService
     */
    public function __construct(MongoDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * @param $id
     * @return Event|null
     */

    public function findById($id)
    {
        $data = $this->normalize($this->getCollection()->find(['_id' => $id]));
        if (!empty($data))
            return $data[0];
        return null;
    }

    /**
     * @return Event[]
     */
    public function getAll()
    {
        return $this->normalize($this->getCollection()->find());
    }

    /**
     * @return \MongoDB\Collection
     */
    protected function getCollection()
    {
        return $this->dataService->getCollection(static::DB_NAME, static::COLLECTION_NAME);
    }

    /**
     * @param Event $event
     * @return bool
     */
    public function insertOne(Event $event)
    {
        $event = $this->prepareEvent($event);
        $result = $this->getCollection()->insertOne($event);
        return $result->getInsertedCount() ? true : false;
    }

    /**
     * @param int $id
     * @param array $fieldsToUpdate
     * @return bool
     */
    public function updateOne($id, $fieldsToUpdate)
    {
        $result = $this->getCollection()->updateOne(['_id' => $id], ['$set' => $fieldsToUpdate]);
        return $result->getUpsertedCount() ? true : false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteOne($id)
    {
        $result = $this->getCollection()->deleteOne(['_id' => $id]);
        return $result->getDeletedCount() ? true : false;
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

    private function normalize($entities)
    {
        $result = [];
        foreach ($entities as $entity) {
            $result[] = new Event($entity);
        }
        return $result;
    }

}