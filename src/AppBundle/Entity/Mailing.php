<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Mailing
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Mailing
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;


    /**
     * @var array
     *
     * @ORM\Column(name="mails", type="array")
     */
    private $mails;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true)
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * @var array
     *
     * @ORM\Column(name="sentAt", type="datetime", nullable=true)
     */
    private $sentAt;

    /**
     * Hook timestampable behavior
     * updates publishedAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;


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
     *
     * @return Mailing
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set mails
     *
     * @param array $mails
     *
     * @return Mailing
     */
    public function setMails($mails)
    {
        $this->mails = $mails;

        return $this;
    }

    /**
     * Get mails
     *
     * @return array
     */
    public function getMails()
    {
        return $this->mails;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Mailing
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set sentAt
     *
     * @param \DateTime $sentAt
     *
     * @return Mailing
     */
    public function setSentAt(\DateTime $sentAt)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * Get sentAt
     *
     * @return \DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }
}
