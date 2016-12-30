<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 12/29/16
 * Time: 2:02 PM
 */

namespace IspMonitor\Providers;

use MongoDB;

class MongoDBDataProvider
{

    /**
     * @var MongoDB\Client
     */
    protected $client;

    const DEFAULT_CONNECTION_SETTINGS = "mongodb://localhost:27017";

    /**
     *
     * MongoDBDataProvider constructor.
     * @param string $connectionSettings
     */
    public function __construct($connectionSettings = self::DEFAULT_CONNECTION_SETTINGS)
    {
        $this->client = new MongoDB\Client($connectionSettings);
    }

    /**
     * @return MongoDB\Client
     */
    public function getClient()
    {
        return $this->client;
    }

}