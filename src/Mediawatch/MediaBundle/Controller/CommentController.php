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

use Mediawatch\MediaBundle\Form\Media\CommentMedia;
use Mediawatch\MediaBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/comment/{media_id}", name="comment_new", requirements={"media_id" = "\d+"})
     */
    public function newAction(Request $request)
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {
            $media = $this->getDoctrine()
                ->getRepository('MediawatchMediaBundle:Media')
                ->findOneById($request->get('media_id'));

            $comment = new Comment();
            $comment->setMedia($media);
            $comment->setMediaId($media->getId());

            $form = $this->createForm(new CommentMedia(), $comment);

            if ($request->getMethod() == 'POST') {
                $form->bind($request);

                if ($form->isValid()) {

                    $comment = $form->getData();
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($comment);
                    $em->flush();

                    $ret['status'] = 'success';
                    $ret['content'] = $this->listAction($media->getId());

                    $response = new Response(json_encode($ret));
                    $response->headers->set('Content-type', 'application/json; charset=utf-8');

                    return $response;
                } else {
                    $ret['status'] = 'failure';
                    $ret['content'] = $this->renderView(
                        'MediawatchMediaBundle:Comment:new.html.twig',
                        array('form' => $form->createView(), 'media' => $media, 'errors' => true)
                    );

                    $response = new Response(json_encode($ret));
                    $response->headers->set('Content-type', 'application/json; charset=utf-8');

                    return $response;
                }
            }

            return $this->render(
                'MediawatchMediaBundle:Comment:new.html.twig',
                array('form' => $form->createView(), 'media' => $media)
            );
        }
    }

    /**
     * @Template()
     */
    public function listAction($media_id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MediawatchMediaBundle:Comment');
        $comments = $repository->getMediaComments($media_id);

        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            return $this->renderView('MediawatchMediaBundle:Comment:list.html.twig', array('comments' => $comments));
        }

        return $this->render('MediawatchMediaBundle:Comment:list.html.twig', array('comments' => $comments));
    }
}
