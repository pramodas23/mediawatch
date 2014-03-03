<?php

namespace Mediawatch\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use Doctrine\ORM\Query;

/**
 * Class CategoryController
 * @package Mediawatch\ApiBundle\Controller
 */
class CategoryController extends FOSRestController
{
    /**
     * @Route("/category", name="api_category_list")
     * @Template()
     */
    public function getCategoryListAction()
    {
        $categoryItems = $this->fetchCategoryItems();
        $formattedCategoryItems = $this->container->get('mediawatch_api.helper.category_list')->buildArray($categoryItems);

        $view = View::create(array('media' => $formattedCategoryItems))
            ->setStatusCode(200)
            ->setEngine('twig')
            ->setTemplate('MediawatchApiBundle:Error:noHtml.html.twig')
            ->setTemplateVar('media')
            ->setData($formattedCategoryItems);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Fetch the category items from the repository
     *
     * @return \RecursiveIteratorIterator
     */
    protected function fetchCategoryItems()
    {
        $countCategoryItems = $this->container->get('request')->get('count') ?: $this->container->getParameter('api_items_per_page');
        $pageCategoryItems = $this->container->get('request')->get('page') ?: 1;
        $sortCategoryItems = $this->container->get('request')->get('sort') ?: 'DESC';

        $categoryRepository = $this->getDoctrine()->getRepository('MediawatchMediaBundle:Category');
        $categoryItems = $categoryRepository->getAllCategories(Query::HYDRATE_ARRAY);

        return new \RecursiveArrayIterator($categoryItems);
    }
}