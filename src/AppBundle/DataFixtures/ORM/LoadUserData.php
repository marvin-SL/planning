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

    public function saveUser(ObjectManager $manager, $username,$email, $role ){
        $user = new User();

        $user->setUsername($username);
        $user->setEmail($username . '@cmw.com');
        $user->addRole($role);
        $user->setEnabled('1');

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword('Culture&MetiersDuWeb2014-2016', $user->getSalt()));

        $manager->persist($user);

    }
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {

        $this->saveUser($manager, 'marvin', 'saytaine@gmail.com', 'ROLE_ADMIN');
        $this->saveUser($manager, 'laure', 'saytaine@gmail.com', 'ROLE_ADMIN');

        $manager->flush();
    }
}
