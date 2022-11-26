<?php

namespace App\Library\Cache\Provider;

use App\Library\Cache\Connector\RedisConnector;

class RedisProvider
{
    /**
     * @var RedisConnector
     */
    private $connector;

    public function __construct(RedisConnector $connector)
    {
        $this->connector = $connector;
    }

    public function getConnector()
    {
        return $this->connector;
    }

    /**
     * @param string $keyName
     * @param $data
     * @param int $setTimeOut
     * @return bool
     */
    public function set(string $keyName, $data, int $setTimeOut = -1): bool
    {
        try {
            $primary = $this->connector->master()->connect();
            $result = $primary->set($keyName, $data);
            if ($setTimeOut > 0) {
                $primary->expire($keyName, $setTimeOut);
            }
            $primary->close();
            return $result;
        } catch(\Exception $e){
            return false;
        }
    }

    /**
     * @param string $keyName
     * @param float $timeOut
     * @param int $retryInterval
     * @param float $readTimeout
     * @return string|null
     */
    public function get(string $keyName, float $timeOut = 0.0, int $retryInterval = 0, float $readTimeout = 0.0): ?string
    {
        try {
            $replica = $this->connector->slave()->connect($timeOut, $retryInterval, $readTimeout);
            $data = $replica->get($keyName);
            $replica->close();
            return $data;
        } catch(\Exception $e){
            return null;
        }
    }
}
