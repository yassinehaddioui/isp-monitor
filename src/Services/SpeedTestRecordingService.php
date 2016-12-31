<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 12/30/16
 * Time: 1:26 PM
 */

namespace IspMonitor\Services;

use MongoDB\BSON\Serializable;

class SpeedTestRecordingService extends RecordingService
{
    const DB_NAME = 'speedtest';
    const COLLECTION_NAME = 'logs';

    /**
     * @param Serializable $serializable
     * @return \MongoDB\InsertOneResult
     */
    public function insertSpeedTest(Serializable $serializable)
    {
        $collection = $this->getClient()->selectCollection(static::DB_NAME, static::COLLECTION_NAME);
        return $collection->insertOne($serializable);
    }

    /**
     * Returns a SpeedTest collection
     * @return \MongoDB\Collection
     */
    protected function getLogsCollection()
    {
        return $this->client->selectCollection(static::DB_NAME, static::COLLECTION_NAME);

    }

    /**
     * Returns a populated SpeedTest collection in an array format, ready to be JSON encoded.
     * @param array $filters
     * @param array $options
     * @return array
     */
    public function getLogs($filters = [], $options = [])
    {
        $collection = $this->getLogsCollection();
        /* Init `projection` if not set */
        $options['projection'] = $options['projection'] ?: [];
        /* Set or override `_id` to 0 */
        $options['projection']['_id'] = 0;
        $data = $collection->find($filters, $options)->toArray() ?: [];
        return $data;
    }
}