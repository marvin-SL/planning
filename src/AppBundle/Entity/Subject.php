<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subject
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Subject
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="roomNb", type="integer")
     */
    private $roomNb;

    /**
     * @var string
     *
     * @ORM\Column(name="teacher", type="string", length=255)
     */
    private $teacher;


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
     * @return Subject
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
     * Set roomNb
     *
     * @param integer $roomNb
     *
     * @return Subject
     */
    public function setRoomNb($roomNb)
    {
        $this->roomNb = $roomNb;

        return $this;
    }

    /**
     * Get roomNb
     *
     * @return integer
     */
    public function getRoomNb()
    {
        return $this->roomNb;
    }

    /**
     * Set teacher
     *
     * @param string $teacher
     *
     * @return Subject
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return string
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
}

