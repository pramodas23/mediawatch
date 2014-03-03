<?php

/**
 * MediaWatch
 *
 * Copyright (c) 2012-2013, MediaWatch
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mediawatch\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Controller
{

    /**
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MediawatchMediaBundle:Category');
        $categories = $repository->getMostUsedCategories();

        return array('categories' => $categories);
    }
}
