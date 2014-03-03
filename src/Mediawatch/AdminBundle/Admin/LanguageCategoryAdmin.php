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
 * Admin for language categories
 *
 * This class handles fields for the language categories data.
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

class LanguageCategoryAdmin extends Admin
{
    /**
     * Form fields configuration
     *
     * This function adds Name to the form mapper.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        if($this->isChild()) {
            $formMapper
                ->add('category')
                ->add('language');
        } else {

        $formMapper
            ->add('category', 'sonata_type_model')
            ->add('language', 'sonata_type_model');
        }
    }
}