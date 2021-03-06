<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EventRepository")
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
     * @ORM\Column(name="notice", type="string", length=255, nullable=true)
     */
    private $notice;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
   * @Assert\NotBlank()
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar", cascade={"persist"}, inversedBy="events")
   * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
   */
    private $calendar;

    /**
   * @Assert\NotBlank()
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Subject", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
   */
    private $subject;

    /**
   * @Assert\NotBlank()
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Classroom", cascade={"persist"}, inversedBy="events")
   * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
   */
    private $classroom;

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
     *
     * @return \AppBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set classroom
     *
     * @param \AppBundle\Entity\Classroom $classroom
     *
     * @return Event
     */
    public function setClassroom(\AppBundle\Entity\Classroom $classroom)
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * Get classroom
     *
     * @return \AppBundle\Entity\Classroom
     */
    public function getClassroom()
    {
        return $this->classroom;
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

    public function __clone()
    {
        // If the entity has an identity, proceed as normal.
        if ($this->id) {
            $event = new Event();
            $event->id = null;
        }
        // otherwise do nothing, do NOT throw an exception!
    }
}
