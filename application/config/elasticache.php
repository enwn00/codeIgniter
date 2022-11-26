<?php

/**
 * Elasticache configure
 */
$config['primary'] = [
    'hostname' => 'redis-master',
    'port' => '6379',
    'password' => 'test1234',
];

$config['replica'] = [
    'hostname' => 'redis-slave',
    'port' => '6379',
    'password' => 'test1234',
];
