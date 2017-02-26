<?php


namespace IspMonitor\Services;

use IspMonitor\Providers\MongoDBDataProvider;


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