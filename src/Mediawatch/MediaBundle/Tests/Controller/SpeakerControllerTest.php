<?php

/**
 * MediaWatch
 *
 * Copyright (c) 2012-2013, MediaWatch
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mediawatch\MediaBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Mediawatch\MediaBundle\Controller\SpeakerController;

class SpeakerControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(
            array(
                'Mediawatch\MediaBundle\Tests\Fixtures\LoadSpeakerData'
            )
        );
    }

    public function testGetSingleSpeakerReturnsValidResponse()
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/speaker/joe-bloggs/1',
            array(),
            array(),
            array(
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            )
        );

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Joe Bloggs', $response->getContent(), 'Name was not set correctly!');
        $this->assertContains("This is Joe Bloggs&#039; bio.", $response->getContent(), 'Bio was not set correctly!');
    }

    public function testGetSpeakerReturnsNotFoundWithInvalidRequest()
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/speaker/joe-bloggs/999',
            array(),
            array(),
            array(
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            )
        );

        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetSpeakerReturns500IfNotAjax()
    {
        // Tests that the action throws an exception if the request is not an AJAX request
        $client = static::createClient();

        $client->request('GET', '/speaker/joe-bloggs/1');

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
