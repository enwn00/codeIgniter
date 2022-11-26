<?php

namespace App\Library\Cache;

use App\Library\Cache\Connector\ElasticacheRedisConnector;
use App\Library\Cache\Connector\RedisConnector;
use App\Library\Cache\Provider\ElasticacheRedisProvider;
use App\Library\Cache\Provider\RedisProvider;

class CacheManager
{
    static private $oInstance;

    private $cacheProvider;

    public static function getInstance(): CacheManager
    {
        if (empty(self::$oInstance)) {
            self::$oInstance = new self();
        }

        return self::$oInstance;
    }

    /**
     * @param string $driver
     */
    public function driver(string $driver)
    {
        // 추후에 Memcached가 추가될 경우 여기에 넣는다.
        switch ($driver) {
            case 'elasticache' :
                if (!empty($this->cacheProvider)) {
                    return $this->cacheProvider;
                }
                return $this->cacheProvider = (new ElasticacheRedisProvider(new ElasticacheRedisConnector()));
            case 'redis' :
                if (!empty($this->cacheProvider)) {
                    return $this->cacheProvider;
                }
                return $this->cacheProvider = (new RedisProvider(new RedisConnector()));
        }

        throw new \InvalidArgumentException("Unsupported driver [$driver].");
    }
}
