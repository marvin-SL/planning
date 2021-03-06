<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;


class LoadUserData extends AbstractFixture implements ContainerAwareInterface
{
    /**
    * @var ContainerInterface
    */
    private $container;

    /**
    * {@inheritDoc}
    */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function saveUser(ObjectManager $manager,$username, $firstname, $lastname, $email, $role, $date ){
        $user = new User();

        $user->setUsername($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($username . '@cmw.com');
        $user->addRole($role);
        $user->setEnabled('1');
        $user->setPasswordChangedAt($date);

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword('cmw', $user->getSalt()));

        $manager->persist($user);

    }
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {

        $this->saveUser($manager, 'marvin.sainteluce','marvin','sainte-luce', 'saytaine@gmail.com', 'ROLE_SUPER_ADMIN', $date = new \DateTime());
        $this->saveUser($manager, 'laure.robillard', 'laure','robillard', 'saytaine@gmail.com', 'ROLE_ADMIN', $date=null);
        $this->saveUser($manager, 'dean.winchester', 'dean','winchester', 'saytaine@gmail.com', 'ROLE_EDITOR', $date=null);

        $manager->flush();
    }
}
