<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Event
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
     * @ORM\Column(name="notice", type="string", length=255)
     * @ORM\JoinColumn(nullable=false)
     */
    private $notice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar", cascade={"persist"}, inversedBy="events", fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
    private $calendar;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Subject", cascade={"persist"}, inversedBy="events", fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
    private $subject;

    /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ClassRoom", cascade={"persist"}, inversedBy="events", fetch="EAGER")
   * @ORM\JoinColumn(nullable=false)
   */
    private $classRoom;

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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set calendar
     *
     * @param \AppBundle\Entity\Calendar $calendar
     *
     * @return Event
     */
    public function setCalendar(\AppBundle\Entity\Calendar $calendar)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return \AppBundle\Entity\Calendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * Set subject
     *
     * @param \AppBundle\Entity\Subject $subject
     *
     * @return Event
     */
    public function setSubject(\AppBundle\Entity\Subject $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject

     * @VirtualProperty
     * @SerializedName("")
     *
     * @return \AppBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set classRoom
     *
     * @param \AppBundle\Entity\ClassRoom $classRoom
     *
     * @return Event
     */
    public function setClassRoom(\AppBundle\Entity\ClassRoom $classRoom)
    {
        $this->classRoom = $classRoom;

        return $this;
    }

    /**
     * Get classRoom
     *
     * @return \AppBundle\Entity\ClassRoom
     */
    public function getClassRoom()
    {
        return $this->classRoom;
    }

    /**
     * Set notice
     *
     * @param string $notice
     *
     * @return Event
     */
    public function setNotice($notice)
    {
        $this->notice = $notice;

        return $this;
    }

    /**
     * Get notice
     *
     * @return string
     */
    public function getNotice()
    {
        return $this->notice;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Event
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
