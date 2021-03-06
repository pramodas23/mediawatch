<?php

namespace Mediawatch\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mediawatch\MediaBundle\Entity\Feed
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mediawatch\MediaBundle\Entity\FeedRepository")
 */
class Feed
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer $feedtype_id
     *
     * @ORM\Column(name="feedtype_id", type="integer")
     */
    private $feedtype_id;

    /**
     * @ORM\ManyToOne(targetEntity="Feedtype", inversedBy="feeds")
     * @ORM\JoinColumn(name="feedtype_id", referencedColumnName="id")
     */
    protected $feedtype;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=200)
     */
    private $url;

    /**
     * @var boolean $automaticImport
     *
     * @ORM\Column(name="automaticImport", type="boolean", nullable=true)
     */
    private $automaticImport;

    /**
     * @var string $contact
     *
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @var string $confirmation
     *
     * @ORM\Column(name="confirmation", type="string", length=20)
     */
    private $confirmation;

    /**
     * @var text $remark
     *
     * @ORM\Column(name="remark", type="text", nullable=true)
     */
    private $remark;

    /**
     * @var \DateTime $lastImportedDate
     *
     * @ORM\Column(name="lastImportedDate", type="date", nullable=true)
     */
    private $lastImportedDate;

    /**
     * @var integer $mediatype_id
     *
     * @ORM\Column(name="mediatype_id", type="integer")
     */
    private $mediatype_id;

    /**
     * @ORM\ManyToOne(targetEntity="Mediatype", inversedBy="feeds")
     * @ORM\JoinColumn(name="mediatype_id", referencedColumnName="id")
     */
    protected $mediatype;

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set feedtype_id
     *
     * @param integer $feedtypeId
     */
    public function setFeedtypeId($feedtypeId)
    {
        $this->feedtype_id = $feedtypeId;
    }

    /**
     * Get feedtype_id
     *
     * @return integer
     */
    public function getFeedtypeId()
    {
        return $this->feedtype_id;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set automaticImport
     *
     * @param boolean $automaticImport
     */
    public function setAutomaticImport($automaticImport)
    {
        $this->automaticImport = $automaticImport;
    }

    /**
     * Get automaticImport
     *
     * @return boolean
     */
    public function getAutomaticImport()
    {
        return $this->automaticImport;
    }

    /**
     * Set contact
     *
     * @param string $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set confirmation
     *
     * @param string $confirmation
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;
    }

    /**
     * Get confirmation
     *
     * @return string
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * Set remark
     *
     * @param text $remark
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    /**
     * Get remark
     *
     * @return text
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set feedtype
     *
     * @param Mediawatch\MediaBundle\Entity\Feedtype $feedtype
     */
    public function setFeedtype(\Mediawatch\MediaBundle\Entity\Feedtype $feedtype)
    {
        $this->feedtype = $feedtype;
    }

    /**
     * Get feedtype
     *
     * @return Mediawatch\MediaBundle\Entity\Feedtype
     */
    public function getFeedtype()
    {
        return $this->feedtype;
    }

    /**
     * Set lastImportedDate
     *
     * @param \DateTime $lastImportedDate
     * @return Feed
     */
    public function setLastImportedDate($lastImportedDate)
    {
        $this->lastImportedDate = $lastImportedDate;
    
        return $this;
    }

    /**
     * Get lastImportedDate
     *
     * @return \DateTime 
     */
    public function getLastImportedDate()
    {
        return $this->lastImportedDate;
    }

    /**
     * Set mediatype_id
     *
     * @param integer $mediatypeId
     * @return Feed
     */
    public function setMediatypeId($mediatypeId)
    {
        $this->mediatype_id = $mediatypeId;
    
        return $this;
    }

    /**
     * Get mediatype_id
     *
     * @return integer 
     */
    public function getMediatypeId()
    {
        return $this->mediatype_id;
    }

    /**
     * Set mediatype
     *
     * @param \Mediawatch\MediaBundle\Entity\Mediatype $mediatype
     * @return Feed
     */
    public function setMediatype(\Mediawatch\MediaBundle\Entity\Mediatype $mediatype = null)
    {
        $this->mediatype = $mediatype;
    
        return $this;
    }

    /**
     * Get mediatype
     *
     * @return \Mediawatch\MediaBundle\Entity\Mediatype 
     */
    public function getMediatype()
    {
        return $this->mediatype;
    }
}
