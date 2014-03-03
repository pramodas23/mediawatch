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
use Mediawatch\MediaBundle\Entity\MediaSpeaker;
use Mediawatch\MediaBundle\Entity\Speaker;
use Mediawatch\MediaBundle\Entity\Media;

class LoadMediaSpeakerData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $nils = new MediaSpeaker();
        $nils->setSpeaker($this->getReference('nils-adermann'));
        $nils->setMedia($this->getReference('phpbb4'));

        $lorna = new MediaSpeaker();
        $lorna->setSpeaker($this->getReference('lorna-mitchell'));
        $lorna->setMedia($this->getReference('toolUpYourLampStack'));


        $manager->persist($nils);
        $manager->persist($lorna);

        $manager->flush();

        $this->addReference('nils', $nils);
        $this->addReference('lorna', $lorna);
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
            'Mediawatch\MediaBundle\Tests\Fixtures\LoadSpeakerData',
            'Mediawatch\MediaBundle\Tests\Fixtures\LoadMediaData',
        );
    }
}
