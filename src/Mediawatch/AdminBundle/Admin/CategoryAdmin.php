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
 * Admin for categories
 *
 * This class handles fields for the category data.
 *
 * @category   AdminBundle
 * @author     <author>
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

class CategoryAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_by' => 'name' // name of the ordered field (default = the model id field, if any)
    );
    
    /**
     * Configure form fields
     *
     * This function adds parent_id as required field to the form mapper object.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name')->add('parent_id', null, array('required' => false));
    }

    /**
     * Configure data grid filters
     *
     * This function adds Name field to data grid mapper.
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    /**
     * Configure list fields
     *
     * This function configures list fields by adding identifier
     * of Name to parent_id.
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name')->add('parent_id');
    }
}
