<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
* @ORM\Entity
* @ORM\Table(name="user")
*/
class User extends BaseUser
{
  /**
  * @ORM\Id
  * @ORM\Column(type="integer")
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
   */
  protected $firstname;

  /**
   * @var string
   *
   * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
   */
  protected $lastname;

  /**
   * @var \DateTime $createdAt
   *
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(type="datetime")
   */
  private $createdAt;

  /**
   * @var \DateTime $updatedAt
   *
   * @Gedmo\Timestampable(on="update")
   * @ORM\Column(type="datetime")
   */
  private $updatedAt;

  /**
   * @var \DateTime $passwordChangedAt
   *
   * @Gedmo\Timestampable(on="change", field={"password"})
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $passwordChangedAt;


  public function __construct()
  {
    parent::__construct();

  }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
    * Get highest role of the user
    *
    * @return ArrayCollection
    */
    public function getHighestRole()
    {
        $highestRole = "Utilisateur";
        if ($this->hasRole('ROLE_SUPER_ADMIN')) {
            $highestRole = "Super administrateur";
        } elseif ($this->hasRole('ROLE_ADMIN')) {
            $highestRole = "Administrateur";
        }

        return $highestRole;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set passwordChanged
     *
     * @param \DateTime $passwordChanged
     *
     * @return User
     */
    public function setPasswordChanged($passwordChanged)
    {
        $this->passwordChanged = $passwordChanged;

        return $this;
    }

    /**
     * Get passwordChanged
     *
     * @return \DateTime
     */
    public function getPasswordChanged()
    {
        return $this->passwordChanged;
    }

    /**
     * Set passwordChangedAt
     *
     * @param \DateTime $passwordChangedAt
     *
     * @return User
     */
    public function setPasswordChangedAt($passwordChangedAt)
    {
        $this->passwordChangedAt = $passwordChangedAt;

        return $this;
    }

    /**
     * Get passwordChangedAt
     *
     * @return \DateTime
     */
    public function getPasswordChangedAt()
    {
        return $this->passwordChangedAt;
    }
}
