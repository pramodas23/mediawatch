<?php

/**
 * MediaWatch
 *
 * Copyright (c) 2012-2013, MediaWatch
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mediawatch\MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * MediaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MediaRepository extends EntityRepository
{
    /**
     * Query database for a fixed number of media records ordered by
     * one or more specific fields.
     *
     * If $sort and $order are strings, the resultset will be ordered by $sort
     * in the order set in $order. If $sort is an array and $order is a string,
     * the resultset will be ordered by the fields named in $sort in the order
     * set in $order. If $sort and $order are arrays, each array element of
     * $order is treated as the sort order of the field in $sort with the same
     * index. In the last case, $sort and $order must be the same size.
     *
     * @param string|array $sort
     * @param int          $page
     * @param int          $max
     * @param string|array $order
     *
     * @return array Array with total and results
     * @throws \Exception If the sizes of $sort and $order do not match
     */
    public function getMediaOrderedBy($sort, $page, $max, $order = 'DESC')
    {
        $sort = $this->cleanSort($sort);
        $order = $this->cleanOrder($sort, $order);

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("m")
           ->from("MediawatchMediaBundle:Media", "m")
           ->where("m.status = :status");

        $this->addOrderByToQueryBuilder($qb, 'm', $sort, $order);

        $qb->addOrderBy('m.date', 'DESC');

        $query = $qb->getQuery();
        $query->setParameter("status", Media::STATUS_PUBLISHED);

        $results = $query->getResult();

        return $this->getResultList($results, $page, $max);
    }

    /**
     * Create result list by manually doing the limit/offset
     *
     * @param array $results
     * @param int   $page
     * @param int   $max
     *
     * @return array Array with total and results
     */
    private function getResultList($results, $page, $max)
    {
        $start = ($page - 1) * $max;
        $end = ($page * $max) - 1;
        $total = count($results);

        $result = array();
        for ($i = $start; $i <= $end && $i < $total; $i++) {
            $result[] = $results[$i];
        }

        return array('total' => $total, 'results' => $result);
    }

    /**
     * Find media by search term
     *
     * @param string $search
     * @param string|array $sort
     * @param int    $page
     * @param int    $max
     * @param string|array $order
     *
     * @return array Array with count and result
     * @throws \Exception If the sizes of $sort and $order do not match
     */
    public function findMedia($search, $sort, $page, $max, $order)
    {
        $sort = $this->cleanSort($sort);
        $order = $this->cleanOrder($sort, $order);

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("m")->distinct(true)
           ->from("MediawatchMediaBundle:Media", "m")
           ->leftJoin('m.languageCategories', 'mlc')     
           ->leftJoin("mlc.languageCategory", "lc")
           ->leftJoin("lc.category", "c")
           ->leftJoin("m.tags", "mt")
           ->leftJoin('mt.tag', 't')     
           ->join("m.speakers", "ms")
           ->join('ms.speaker', 's')     
           ->join("m.mediatype", "mtype")
           ->where(
               $qb->expr()->andX(
                   $qb->expr()->orX(
                       "LOWER(c.name) LIKE :search1",
                       "LOWER(t.name) LIKE :search2",
                       "LOWER(s.name) LIKE :search3",
                       "LOWER(m.title) LIKE :search4",
                       "LOWER(m.description) LIKE :search5",
                       "LOWER(mtype.name) LIKE :search6"
                   ),
                   "m.status = :status"
               )
           );

        $this->addOrderByToQueryBuilder($qb, 'm', $sort, $order);

        $qb->addOrderBy('m.date', 'DESC');

        $query = $qb->getQuery();
        $query->setParameter('search1', '%'.strtolower($search).'%')
              ->setParameter('search2', '%'.strtolower($search).'%')
              ->setParameter('search3', '%'.strtolower($search).'%')
              ->setParameter('search4', '%'.strtolower($search).'%')
              ->setParameter('search5', '%'.strtolower($search).'%')
              ->setParameter('search6', '%'.strtolower($search).'%')
              ->setParameter("status", Media::STATUS_PUBLISHED);
        $results = $query->getResult();

        return $this->getResultList($results, $page, $max);
    }

    /**
     * Override native findOneBySlug method to include
     * mediatype join, reducing no. of queries to db
     * and increment no of visits made to media item
     *
     * @param  string   $slug
     * @return Doctrine Record
     */
    public function findOneBySlug($slug)
    {
        $query = $this->createQueryBuilder('m')
            ->where('m.slug = :slug')
            ->andWhere('m.status = :status')
            ->setParameter('slug', $slug)
            ->setParameter("status", Media::STATUS_PUBLISHED);

        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * Find media items by category
     *
     * @param string $slug       (category name)
     * @param string $orderField
     * @param int    $page
     * @param int    $max
     * @param string $order
     *
     * @return array Array with total and results
     */
    public function findByCategory($slug, $orderField, $page, $max, $order = 'DESC')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("m")
           ->from("MediawatchMediaBundle:Media", "m")
           ->leftJoin('m.languageCategories', 'mlc')     
           ->leftJoin("mlc.languageCategory", "lc")
           ->leftJoin("lc.category", "c")
           ->where(
               $qb->expr()->andX(
                   "c.slug = :slug",
                   "m.status = :status"
               )
           )
           ->orderBy("m." . $orderField, $order);
        $query = $qb->getQuery();
        $query->setParameter("slug", $slug)
              ->setParameter("status", Media::STATUS_PUBLISHED);

        $results = $query->getResult();

        return $this->getResultList($results, $page, $max);
    }

    /**
     * Find media items by tag
     *
     * @param string $slug       (tag name)
     * @param string $orderField
     * @param int    $page
     * @param int    $max
     * @param string $order
     *
     * @return array Array with total and results
     */
    public function findByTag($slug, $orderField, $page, $max, $order = 'DESC')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("m")
           ->from("MediawatchMediaBundle:Media", "m")
           ->join('m.tags', 'mt')     
           ->join("mt.tag", "t")
           ->where(
               $qb->expr()->andX(
                   "t.slug = :slug",
                   "m.status = :status"
               )
           )
           ->orderBy("m." . $orderField, $order);
        $query = $qb->getQuery();
        $query->setParameter("slug", $slug)
              ->setParameter("status", Media::STATUS_PUBLISHED);
        $results = $query->getResult();

        return $this->getResultList($results, $page, $max);
    }

    /**
     * Find media items by speaker
     *
     * @param int    $speakerId
     * @param string $orderField
     * @param int    $page
     * @param int    $max
     *
     * @return array Array with total and results
     */
    public function findBySpeaker($speakerId, $orderField, $page, $max)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("m")
           ->from("MediawatchMediaBundle:Media", "m")
           ->join('m.speakers', 'ms')     
           ->join("ms.speaker", "s")
           ->where(
               $qb->expr()->andX(
                   "s.id = :speakerId",
                   "m.status = :status"
               )
           )
           ->orderBy("m." . $orderField, "DESC");
        $query = $qb->getQuery();
        $query->setParameter('speakerId', $speakerId)
              ->setParameter("status", Media::STATUS_PUBLISHED);
        $results = $query->getResult();

        return $this->getResultList($results, $page, $max);
    }

    /**
     * Find media items by title or permalink (for import command)
     *
     * @param $permalink
     * @param int $hydrator @see Doctrine\ORM\Query
     * @return bool
     */
    public function itemExists($permalink, $hydrator = Query::HYDRATE_OBJECT)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("m")
            ->from("MediawatchMediaBundle:Media", "m")
            ->where("m.hostUrl = :permalink");

        $query = $qb->getQuery();
        $query->setParameter('permalink', $permalink);
        $media = $query->getResult($hydrator);

        if (count($media) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Increment number of visits to media item
     *
     * @param object $media
     */
    public function incrementVisitCount($media)
    {
        $currentVisits = $media->getVisits();
        $media->setVisits($currentVisits + 1);
        $this->getEntityManager()->flush();
    }

    /**
     * Get the average rating of a media item
     *
     * @param  integer $mediaId
     * @return integer
     */
    public function getAverageRating($mediaId)
    {
        $result = $this->getEntityManager()
                       ->createQuery(
                           'SELECT AVG(r.rating)
                            FROM MediawatchMediaBundle:Rating r
                            WHERE r.media_id=:id'
                       )
                       ->setParameter('id', $mediaId)
                       ->getResult();

        $average = $result[0][1];

        return $average;
    }

    /**
     * @param string|array $sort
     * @return array
     */
    protected function cleanSort($sort)
    {
        if (!is_array($sort)) {
            $sort = array($sort);
        }

        return $sort;
    }

    /**
     * @param array $sort
     * @param string|array $order
     * @return array
     * @throws \Exception
     */
    protected function cleanOrder($sort, $order)
    {
        // Sort out the different cases of array parameters this method takes
        if (!is_array($order)) {
            $order = array_fill(0, count($sort), $order);
        }
        if (count($sort) > count($order)) {
            /* I don't really care about the size of $order as long as
             * it's bigger than $sort. */
            throw new \Exception(
                "Sizes of sort and order parameters given to ".__CLASS__."::".__FUNCTION__." do not match."
            );
        }

        return $order;
    }

    protected function addOrderByToQueryBuilder(QueryBuilder $qb, $alias, $sort, $order)
    {
        for ($i = 0; $i < count($sort); $i++) {
            $qb->addOrderBy($alias . "." . $sort[$i], $order[$i]);
        }
    }
}