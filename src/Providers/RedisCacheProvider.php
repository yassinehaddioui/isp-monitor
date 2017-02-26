<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 12/28/16
 * Time: 11:15 PM
 */

namespace IspMonitor\Providers;


use IspMonitor\Interfaces\CacheProvider;

/**
 * This implementation requires Redis extension https://github.com/phpredis/phpredis
 *
 * Class RedisCacheProvider
 * @package IspMonitor\Providers
 */

class RedisCacheProvider implements CacheProvider
{
    private $redis;
    private $redisConfig = ['host' => '127.0.0.1', 'port' => 6379];

    /**
     * RedisCacheProvider constructor.
     * @param array $redisConfig
     */
    public function __construct($redisConfig = [])
    {
        if (!empty($redisConfig))
            $this->redisConfig = $redisConfig;
        $this->redis = new \Redis();
        $this->redis->connect($this->redisConfig['host'], $this->redisConfig['port']);
    }

    /**
     * @param string $key
     * @return bool|string
     */
    public function get($key)
    {
        if ($data = $this->redis->get($key))
            return unserialize($data);
        return false;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return bool
     */
    public function set($key, $value, $ttl = 0)
    {
        $value = serialize($value);
        if (!$ttl)
            return $this->redis->set($key, $value);
        else
            return $this->redis->setex($key, $ttl, $value);
    }

    /**
     * @param array $keys
     */

    public function delete($keys)
    {
        $this->redis->delete($keys);
    }

    /**
     * @return \Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }

}