<?php

namespace App\Library\Cache\Connector;

use App\Library\Cache\Connector\Provider\RedisConnectProvider;

class ElasticacheRedisConnector
{
    /**
     * @var array
     */
    private $primary_config;

    /**
     * @var array
     */
    private $replica_config;

    /**
     * @var RedisConnectProvider
     */
    private $primary;

    /**
     * @var RedisConnectProvider
     */
    private $replica;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->config->load('elasticache', TRUE);
        $this->primary_config = $this->CI->config->item('primary', 'elasticache');
        $this->replica_config = $this->CI->config->item('replica', 'elasticache');
    }

    /**
     * @return RedisConnectProvider
     */
    public function primary(): RedisConnectProvider
    {
        if (empty($this->primary)){
            $this->primary = (new RedisConnectProvider($this->primary_config['endpoint'],
                                                $this->primary_config['port'],
                                                $this->primary_config['password']));
        }

        return $this->primary;
    }

    /**
     * @return RedisConnectProvider
     */
    public function replica(): RedisConnectProvider
    {
        if (empty($this->replica)){
            $this->replica = (new RedisConnectProvider($this->replica_config['endpoint'],
                                                $this->replica_config['port'],
                                                $this->replica_config['password']));
        }

        return $this->replica;
    }
}
