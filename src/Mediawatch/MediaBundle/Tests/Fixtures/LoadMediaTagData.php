<?php

/**
 * MediaTest
 *
 * Copyright (c) 2012-2013, MediaTest
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mediawatch\MediaBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mediawatch\MediaBundle\Entity\MediaTag;
use Mediawatch\MediaBundle\Entity\Tag;
use Mediawatch\MediaBundle\Entity\Media;

class LoadMediaTagData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $phpbb4Symfony = new MediaTag();
        $phpbb4Symfony->setTag($this->getReference('symfony'));
        $phpbb4Symfony->setMedia($this->getReference('phpbb4'));

        $toolUpYourLampStackQualityAssurance = new MediaTag();
        $toolUpYourLampStackQualityAssurance->setTag($this->getReference('quality-assurance'));
        $toolUpYourLampStackQualityAssurance->setMedia($this->getReference('toolUpYourLampStack'));


        $manager->persist($phpbb4Symfony);
        $manager->persist($toolUpYourLampStackQualityAssurance);

        $manager->flush();
    }

    /**
     * Load this fixtures dependencies
     * @see https://github.com/doctrine/data-fixtures
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            'Mediawatch\MediaBundle\Tests\Fixtures\LoadTagData',
            'Mediawatch\MediaBundle\Tests\Fixtures\LoadMediaData',
        );
    }
}
