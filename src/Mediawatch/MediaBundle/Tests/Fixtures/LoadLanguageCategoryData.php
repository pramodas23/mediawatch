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
use Mediawatch\MediaBundle\Entity\LanguageCategory;
use Mediawatch\MediaBundle\Entity\Category;
use Mediawatch\MediaBundle\Entity\Language;

class LoadLanguageCategoryData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $toolsPhp = new LanguageCategory();
        $toolsPhp->setLanguage($this->getReference('php'));
        $toolsPhp->setCategory($this->getReference('tools'));

        $toolsJavascript = new LanguageCategory();
        $toolsJavascript->setLanguage($this->getReference('javascript'));
        $toolsJavascript->setCategory($this->getReference('tools'));


        $manager->persist($toolsPhp);
        $manager->persist($toolsJavascript);

        $manager->flush();

        $this->addReference('toolsPhp', $toolsPhp);
        $this->addReference('toolsJavascript', $toolsJavascript);
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
            'Mediawatch\MediaBundle\Tests\Fixtures\LoadLanguageData',
            'Mediawatch\MediaBundle\Tests\Fixtures\LoadCategoryData',
        );
    }
}
