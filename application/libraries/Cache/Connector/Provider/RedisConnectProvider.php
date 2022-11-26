<?php

namespace App\Library\Cache\Connector\Provider;

use App\Library\Cache\Connector\Contracts\ConnectorInterface;
use Redis;

class RedisConnectProvider implements ConnectorInterface
{
    /**
     * @var Redis
     */
    protected $redis;

    /**
     * @var String
     */
    protected $hostname;

    /**
     * @var String
     */
    protected $port;

    /**
     * @var String
     */
    protected $password;

    /**
     * @param string $hostname
     * @param string $port
     * @param string $password
     */
    public function __construct(string $hostname = 'localhost', string $port= '6379', string $password = '')
    {
        $this->hostname = $hostname;
        $this->port = $port;
        $this->password = $password;
    }

    /**
     * @param float $timeOut
     * @param int $retryInterval
     * @param float $readTimeout
     * @return Redis
     */
    public function connect(float $timeOut = 0.0, int $retryInterval = 0, float $readTimeout = 0.0): Redis
    {
        $this->redis = new Redis();
        $this->redis->connect($this->hostname, $this->port, $timeOut, null, $retryInterval, $readTimeout);
        $this->redis->auth($this->password);

        return $this->redis;
    }

    /**
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->redis->isConnected();
    }

    /**
     * @return void
     */
    public function close(): void
    {
        if ($this->isConnected() === true) {
            $this->redis->close();
        }
    }
}
