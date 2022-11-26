<?php

namespace App\Tests\Core;

use CI_Controller;
use PHPUnit\Framework\TestCase;

require ROOTPATH . 'vendor/autoload.php';

class CITestCase extends TestCase
{
    public function __construct()
    {
        parent::__construct();
        new CI_Controller();
    }
}
