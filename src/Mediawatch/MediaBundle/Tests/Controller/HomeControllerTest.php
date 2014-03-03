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
use Mediawatch\MediaBundle\Controller\MediaController;

class HomeControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(
            array(
                'Mediawatch\MediaBundle\Tests\Fixtures\LoadMediaSpeakerData'
            )
        );
    }


    public function testGetFeedReturnsValidResponse()
    {
        $client = static::createClient();

        $client->request('GET', '/feed');

        $response = $client->getResponse();
        $content = $client->getResponse()->getContent();

        // Assertions on the channel
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('<title>MediaWatch RSS feed</title>', $content);
        $this->assertContains(
            '<atom:link href="http://mediawatch.me/feed/" rel="self" type="application/rss+xml" />',
            $content
        );
        $this->assertContains('<link>http://mediawatch.me</link>', $content);

        // Assertions on the items in the feed
        $this->assertContains('<title>Tool Up Your Lamp Stack</title>', $content);
        $this->assertContains('<link>http://mediawatch.me/tool-up-your-lamp-stack</link>', $content);

        $today = new \DateTime('15-07-2013');
        $today = $today->format('d-m-Y');
        
        $this->assertContains('<pubDate>'.$today.'</pubDate>', $content);
        $this->assertContains('<dc:creator>MediaWatch</dc:creator>', $content);
        $this->assertContains('<guid isPermaLink="false">http://mediawatch.me/tool-up-your-lamp-stack</guid>', $content);
        $this->assertContains('<p>A talk about peripheral tools that aid web development</p>', $content);
    }
}
