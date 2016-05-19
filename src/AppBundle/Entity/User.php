<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity(
 *     fields={"firstname", "lastname"},
 *     message="Le couple nom/prenom est déjà pris"
 * )
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
   * @var \DateTime
   *
   * @Gedmo\Timestampable(on="change", field={"password"})
   * @ORM\Column(type="datetime", nullable=true)
   */
    private $passwordChangedAt;

  /**
    * @var boolean
    */
    protected $enabled;

  /*
   * Hook timestampable behavior
   * updates publishedAt, updatedAt fields
   */
    use TimestampableEntity;

  /*
   * Hook blameable behavior
   * updates createdBy, updatedBy fields
   */
    use BlameableEntity;

    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
    }

    /**
     * Set firstname.
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
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
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
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get highest role of the user.
     *
     * @return ArrayCollection
     */
    public function getHighestRole()
    {
        $highestRole = 'Administrateur';
        if ($this->hasRole('ROLE_SUPER_ADMIN')) {
            $highestRole = 'Super administrateur';
        } elseif ($this->hasRole('ROLE_DEV')) {
            $highestRole = 'Black Ninja';
        }

        return $highestRole;
    }

    /**
     * Set passwordChanged.
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
     * Get passwordChanged.
     *
     * @return \DateTime
     */
    public function getPasswordChanged()
    {
        return $this->passwordChanged;
    }

    /**
     * Set passwordChangedAt.
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
     * Get passwordChangedAt.
     *
     * @return \DateTime
     */
    public function getPasswordChangedAt()
    {
        return $this->passwordChangedAt;
    }
}
