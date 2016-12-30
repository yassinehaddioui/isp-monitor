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

class RecordingService
{
    /** @var  MongoDBDataProvider $dataProvider */
    private $dataProvider;

    /**
     * @var \MongoDB\Client
     */
    private $client;


    const DEFAULT_GET_LIMIT = 100;

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
     * @param Serializable $serializable
     * @param string $db
     * @param string $collection
     * @return \MongoDB\InsertOneResult
     */

    public function insertOne(Serializable $serializable, $db, $collection){
        $collection = $this->client->selectCollection($db, $collection);
        return $collection->insertOne($serializable);
    }

    public function getCollection($db, $collection) {
        return $this->client->selectCollection($db, $collection);

    }

}