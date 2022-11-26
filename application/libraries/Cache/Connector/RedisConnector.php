<?php

namespace App\Library\Cache\Connector;

use App\Library\Cache\Connector\Provider\RedisConnectProvider;

class RedisConnector
{
    /**
     * @var array
     */
    private $master_config;

    /**
     * @var array
     */
    private $slave_config;

    /**
     * @var RedisConnectProvider
     */
    private $master;

    /**
     * @var RedisConnectProvider
     */
    private $slave;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->config->load('redis', TRUE);
        $this->master_config = $this->CI->config->item('master', 'redis');
        $this->slave_config = $this->CI->config->item('slave', 'redis');
    }

    /**
     * @return RedisConnectProvider
     */
    public function master(): RedisConnectProvider
    {
        if (empty($this->master)){
            $this->master = (new RedisConnectProvider($this->master_config['hostname'],
                $this->master_config['port'],
                $this->master_config['password']));
        }

        return $this->master;
    }

    /**
     * @return RedisConnectProvider
     */
    public function slave(): RedisConnectProvider
    {
        if (empty($this->slave)){
            $this->slave = (new RedisConnectProvider($this->slave_config['hostname'],
                $this->slave_config['port'],
                $this->slave_config['password']));
        }

        return $this->slave;
    }
}
