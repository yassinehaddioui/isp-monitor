<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/25/17
 * Time: 9:23 PM
 */

namespace IspMonitor\Repositories;

use IspMonitor\Models\Event;
use IspMonitor\Services\MongoDataService;


abstract class BaseRepository
{
    /**
     * @var MongoDataService
     */
    protected $dataService;

    const COLLECTION_NAME = '';
    const DB_NAME = '';
    const ID_PREFIX = '';

    /**
     * EventRepository constructor.
     * @param MongoDataService $dataService
     */
    public function __construct(MongoDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->normalize($this->getCollection()->find());
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
     * @return \MongoDB\Collection
     */
    protected function getCollection()
    {
        return $this->dataService->getCollection(static::DB_NAME, static::COLLECTION_NAME);
    }


    /**
     * @param mixed $object
     * @return bool
     */
    public function insertOne($object)
    {
        $result = $this->getCollection()->insertOne($object);
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


    abstract protected function normalize($entities);

}