<?php

/**
 * MediaWatch
 *
 * Copyright (c) 2012-2013, MediaWatch
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Admin for media language categories
 *
 * This class handles fields for the media language categories data.
 *
 * @category   AdminBundle
 * @author     Lineke Kerckhoffs-Willems <lineke@mediawatch.me>
 * @copyright  2012-2013 MediaWatch
 * @license    http://opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/mediawatch/mediawatch
 * @link       http://www.mediawatch.me
 */

namespace Mediawatch\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MediaLanguageCategoryAdmin extends Admin
{
    protected $parentAssociationMapping = 'media';
    /**
     * Form fields configuration
     *
     * This function adds Name to the form mapper.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $categoryQuery = $this->modelManager
                              ->getEntityManager('Mediawatch\MediaBundle\Entity\LanguageCategory')
                              ->createQuery(
                                  'SELECT lc
                                   FROM MediawatchMediaBundle:languagecategory lc
                                   JOIN lc.category c
                                   JOIN lc.language l
                                   ORDER BY c.name ASC, l.name ASC'
                              );
        
        $formMapper->add('languageCategory',
                         'sonata_type_model',
                         array(
                             'class' => 'Mediawatch\MediaBundle\Entity\LanguageCategory',
                             'query' => $categoryQuery
                         ));
    }

    /**
     * Configure list fields
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('languageCategory')
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'view' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                )
            );
    }
}