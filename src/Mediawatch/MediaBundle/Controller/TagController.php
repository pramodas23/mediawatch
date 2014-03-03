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

class TagController extends Controller
{
    /**
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MediawatchMediaBundle:Tag');
        $tags = $repository->getMostUsedTags();

        return array('tags' => $tags);
    }
}
