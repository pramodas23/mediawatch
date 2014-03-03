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
use Mediawatch\MediaBundle\Entity\MediaLanguageCategory;
use Mediawatch\MediaBundle\Entity\LanguageCategory;
use Mediawatch\MediaBundle\Entity\Media;

class LoadMediaLanguageCategoryData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $phpbb4ToolsPhp = new MediaLanguageCategory();
        $phpbb4ToolsPhp->setLanguageCategory($this->getReference('toolsPhp'));
        $phpbb4ToolsPhp->setMedia($this->getReference('phpbb4'));

        $toolUpYourLampStackToolsJavascript = new MediaLanguageCategory();
        $toolUpYourLampStackToolsJavascript->setLanguageCategory($this->getReference('toolsJavascript'));
        $toolUpYourLampStackToolsJavascript->setMedia($this->getReference('toolUpYourLampStack'));


        $manager->persist($phpbb4ToolsPhp);
        $manager->persist($toolUpYourLampStackToolsJavascript);

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
            'Mediawatch\MediaBundle\Tests\Fixtures\LoadLanguageCategoryData',
            'Mediawatch\MediaBundle\Tests\Fixtures\LoadMediaData',
        );
    }
}
