<?php

/**
 * MediaWatch
 *
 * Copyright (c) 2012-2013, MediaWatch
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mediawatch\MediaBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mediawatch\MediaBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $tools = new Category();
        $tools->setName('Tools');
        $tools->setSlug('tools');

        $manager->persist($tools);

        $manager->flush();

        $this->addReference('tools', $tools);
    }
}
