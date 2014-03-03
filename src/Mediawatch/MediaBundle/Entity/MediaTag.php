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

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Mediawatch\MediaBundle\Entity\MediaTag
 *
 * @ORM\Table(name="media_tag")
 * @ORM\Entity()
 *
 */
class MediaTag
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var integer $media_id
     *
     * @ORM\Column(name="media_id", type="integer")
     */
    private $media_id;

    /**
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="tags")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     */
    protected $media;

    /**
     * @var integer $tag_id
     *
     * @ORM\Column(name="tag_id", type="integer")
     */
    private $tag_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="medias")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     */
    protected $tag;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set media
     *
     * @param \Mediawatch\MediaBundle\Entity\Media $media
     */
    public function setMedia(\Mediawatch\MediaBundle\Entity\Media $media)
    {
        $this->media = $media;
    }

    /**
     * Set tag
     *
     * @param \Mediawatch\MediaBundle\Entity\Tag $tag
     */
    public function setTag(\Mediawatch\MediaBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get media
     *
     * @return \Mediawatch\MediaBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }
    
    /**
     * Get tag
     *
     * @return \Mediawatch\MediaBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
    
    /**
     * Set media_id
     *
     * @param integer $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->media_id = $mediaId;
    }

    /**
     * Get media_id
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->media_id;
    }
    
    /**
     * Set tag_id
     *
     * @param integer $tagId
     */
    public function setTagId($tagId)
    {
        $this->tag_id = $tagId;
    }

    /**
     * Get tag_id
     *
     * @return integer
     */
    public function getTagId()
    {
        return $this->tag_id;
    }
    
    public function __toString() 
    {
        return $this->tag->getName();
    }
}