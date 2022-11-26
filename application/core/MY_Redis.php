<?php
//
////require_once APPPATH.'config/redis.php';
////require_once APPPATH.'config/constants/redis.php';
//
//class MY_Redis extends CI_Model {
//    public $master;
//    public $slave;
//
//    public function __construct() {
//        parent::__construct();
//        $this->connection();
//    }
//
//    private function connection(){
//        $this->config->load('redis', TRUE);
//        $masterConfig = $this->config->item('master', 'redis');
//        $slaveConfig = $this->config->item('slave', 'redis');
//
//        if($this->master_status()) return $this->master;
//        $this->master = new Redis();
//        $this->master->connect($masterConfig['hostname'], $masterConfig['port']);
//        $this->master->auth($masterConfig['password']);
//
//        if($this->slave_status()) return $this->slave;
//        $this->slave = new Redis();
//        $this->slave->connect($slaveConfig['hostname'], $slaveConfig['port']);
//        $this->slave->auth($slaveConfig['password']);
//    }
//
//    private function master_status(): bool
//    {
//        return !empty($this->master->socket);
//    }
//
//    private function slave_status(): bool
//    {
//        return !empty($this->slave->socket);
//    }
//
//    /**
//     * redis disconnection
//     */
//    public function redis_close($params = array())
//    {
//        if(empty($params))
//        {
//            $params = array('master', 'slave');
//        }
//
//        foreach ($params as $value)
//        {
//            (!empty($this->$value->socket)) ? $this->$value->close() : '';
//        }
//    }
//}
