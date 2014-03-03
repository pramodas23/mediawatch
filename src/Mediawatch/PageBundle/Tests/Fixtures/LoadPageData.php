<?php

/**
 * MediaTest
 *
 * Copyright (c) 2012-2013, MediaTest
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mediawatch\PageBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mediawatch\PageBundle\Entity\Page;

class LoadPageData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $page = new Page();
        $page->setPageTitle('News');
        $page->setTitle('News');
        $page->setContent('Some news page content.');
        $page->setUrl('news');

        $manager->persist($page);
        $manager->flush();
    }
}
