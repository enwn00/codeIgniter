<?php

require_once APPPATH.'config/constants/schema.php';

class MY_Model extends CI_Model {
    public $master;
    public $slave;

    public function __construct() {
        parent::__construct();
        $this->master = $this->load->database('master', TRUE);
        $this->slave = $this->load->database('slave', TRUE);
    }
}
