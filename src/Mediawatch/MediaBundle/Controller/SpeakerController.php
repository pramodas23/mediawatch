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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SpeakerController extends Controller
{
    /**
     * @Template()
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MediawatchMediaBundle:Speaker');
        $speakers = $repository->getAllSpeakers();

        return array('speakers' => $speakers);
    }

    /**
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \Exception
     *
     * @Route("/speaker/{name}/{id}", name="speaker_show", requirements={"id" = "\d+"})
     */
    public function showAction($id, $name)
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $speaker[] = $this->getDoctrine()
                ->getRepository('MediawatchMediaBundle:Speaker')
                ->findOneBy(array('id' => $id));

            if ($speaker[0] === null) {
                throw $this->createNotFoundException($name.' not found with id '.$id);
            }

            return $this->render('MediawatchMediaBundle:Speaker:show.html.twig', array('speakers' => $speaker));
        }

        throw new \Exception('Naughty naughty! This should be an ajax request.');
    }
}
