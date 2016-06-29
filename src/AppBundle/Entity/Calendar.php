<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Calendar
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CalendarRepository")
 * @UniqueEntity("title")
 */
class Calendar
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
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event", cascade={"persist"}, mappedBy="calendar")
    */
    private $events;

    /**
     * @Gedmo\Slug(fields={"title"}, updatable=true)
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * @var datetime
     * @ORM\Column(name="lastEventEditedAt", type="datetime", nullable=true)
     */
    private $lastEventEditedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Calendar")
     */
    private $modele;

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
     * Set title
     *
     * @param string $title
     *
     * @return Calendar
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return Calendar
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->events[] = $event;

        $event->setCalendar($this);

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $event
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Calendar
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
     * Set lastEventEditedAt
     *
     * @param \DateTime $lastEventEditedAt
     *
     * @return Calendar
     */
    public function setLastEventEditedAt($lastEventEditedAt)
    {
        $this->lastEventEditedAt = $lastEventEditedAt;

        return $this;
    }

    /**
     * Get lastEventEditedAt
     *
     * @return \DateTime
     */
    public function getLastEventEditedAt()
    {
        return $this->lastEventEditedAt;
    }

    /**
     * Set modele
     *
     * @param \AppBundle\Entity\Calendar $modele
     *
     * @return Calendar
     */
    public function setModele(\AppBundle\Entity\Calendar $modele = null)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele
     *
     * @return \AppBundle\Entity\Calendar
     */
    public function getModele()
    {
        return $this->modele;
    }

    public function __clone()
    {
        // If the entity has an identity, proceed as normal.
        if ($this->id) {
            $calendar = new Calendar();
            $calendar->id = null;

            foreach ($this->getEvents() as $event) {
                $calendar->addEvents($event);
            }
        }
        // otherwise do nothing, do NOT throw an exception!
    }
}
