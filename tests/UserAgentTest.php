<?php

use PHPUnit\Framework\TestCase;

class UserAgentTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://www.ci-project.co:8080/']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testGet()
    {
        $response = $this->http->request('GET', 'index.php/board/1');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $userAgent = json_decode($response->getBody())->{"user-agent"};
        $this->assertRegexp('/Guzzle/', $userAgent);
    }
}
