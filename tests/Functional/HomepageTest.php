<?php

namespace Tests\Functional;

class HomepageTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response.
     */
    public function testGetHomepageWithoutName()
    {
        $this->withMiddleware = false;
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test that the index route won't accept a post request
     */
    public function testPostHomepageNotAllowed()
    {
        $this->withMiddleware = false;
        $response = $this->runApp('POST', '/', ['test']);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }


    public function testHomePageBlockedByAuth()
    {
        $this->withMiddleware = true;
        $response = $this->runApp('GET', '/');

        $this->assertEquals(401, $response->getStatusCode());
    }
}