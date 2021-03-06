<?php

/**
 * MediaTest
 *
 * Copyright (c) 2012-2013, MediaTest
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mediawatch\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PageController extends Controller
{

    /**
     * @Route("/{url}", name="page_show")
     * @Template()
     */
    public function indexAction($url)
    {
        $this->getPage($url);

        return array('page' => $this->page);
    }

    /*
     * Displays page content text from database
     *
     * @param  string   $url
     * @return template
     */
    public function contentAction($url)
    {
        $this->getPage($url);

        return $this->render('MediawatchPageBundle:Page:content.html.twig', array('page' => $this->page));
    }

    /*
     * Retrieves page content text from database
     *
     * @param  string  $url
     * @return boolean
     */
    protected function getPage($url)
    {
        $this->page = $this->getDoctrine()->getRepository('MediawatchPageBundle:Page')->findOneByUrl($url);
        if (!is_object($this->page)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        return true;
    }
}
