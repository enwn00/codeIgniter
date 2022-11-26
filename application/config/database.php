<?php

$active_group = 'default';
$query_builder = TRUE;

/**
 * 간단하게 CI Database 기능 사용
 * PDO configure
 */
$config['pdo'] = [
    'master' => [
        'hostname' => 'mysql-master',
        'port' => '3306',
        'username' => 'test',
        'password' => 'test1234',
        'database' => 'project'
    ],

    'slave' => [
        'hostname' => 'mysql-slave',
        'port' => '3306',
        'username' => 'test',
        'password' => 'test1234',
        'database' => 'project'
    ]
];

$db['master'] = array(
    'dsn'	=> '',
    'hostname' => "mysql:host={$config['pdo']['master']['hostname']};port={$config['pdo']['master']['port']};dbname={$config['pdo']['master']['database']}",
    'username' => $config['pdo']['master']['username'],
    'password' => $config['pdo']['master']['password'],
    'database' => $config['pdo']['master']['database'],
    'dbdriver' => 'pdo',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$db['slave'] = array(
    'dsn'	=> '',
    'hostname' => "mysql:host={$config['pdo']['slave']['hostname']};port={$config['pdo']['slave']['port']};dbname={$config['pdo']['slave']['database']}",
    'username' => $config['pdo']['slave']['username'],
    'password' => $config['pdo']['slave']['password'],
    'database' => $config['pdo']['slave']['database'],
    'dbdriver' => 'pdo',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
