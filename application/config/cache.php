<?php

/**
 * Redis configure
 */

$config['cache'] = [
    'redis' => [
        'master' => [
            'hostname' => 'redis-master',
            'port' => '6379',
            'password' => 'test1234'
        ],

        'slave' => [
            'hostname' => 'redis-slave',
            'port' => '6379',
            'password' => 'test1234'
        ]
    ],
    'elasticache' => [
        'master' => [
            'hostname' => '',
            'port' => '',
            'password' => ''
        ],

        'slave' => [
            'hostname' => '',
            'port' => '',
            'password' => ''
        ]
    ]
];
