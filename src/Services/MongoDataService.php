<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 12/29/16
 * Time: 2:12 PM
 */

namespace IspMonitor\Services;

use IspMonitor\Providers\MongoDBDataProvider;
use MongoDB\BSON\Serializable;

class MongoDataService
{
    /** @var  MongoDBDataProvider $dataProvider */
    protected $dataProvider;

    /**
     * @var \MongoDB\Client
     */
    protected $client;


    /**
     * SpeedTestRecordingService constructor.
     * @param MongoDBDataProvider $dataProvider
     */
    public function __construct(MongoDBDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
        $this->client = $this->dataProvider->getClient();
    }


    /**
     * Inserts a serializable object into a specific collection within a specific db.
     * @param Serializable $serializable
     * @param string $db
     * @param string $collection
     * @return \MongoDB\InsertOneResult
     */

    public function insertOne(Serializable $serializable, $db, $collection)
    {
        $collection = $this->client->selectCollection($db, $collection);
        return $collection->insertOne($serializable);
    }


    /** Returns a specific collection from a specific db.
     * @param $db
     * @param $collection
     * @return \MongoDB\Collection
     */
    public function getCollection($db, $collection)
    {
        return $this->client->selectCollection($db, $collection);

    }

    /**
     * @return \MongoDB\Client
     */
    public function getClient()
    {
        return $this->client;
    }

}