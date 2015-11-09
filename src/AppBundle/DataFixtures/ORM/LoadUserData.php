<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;


class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user2 = new User();

        $user1->setUsername('admin');
        $user1->setPassword('test');
        $user1->setEmail('admin@upem.fr');

        $user2->setUsername('asus');
        $user2->setPassword('test');
        $user2->setEmail('asus@upem.fr');

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }
}
