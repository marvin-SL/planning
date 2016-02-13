<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Mailing;

class LoadMailingData extends AbstractFixture
{
    public function saveMailing(ObjectManager $manager, $name, $mails)
    {
        $mailing = new Mailing();
        $mailing->setName($name);
        $mailing->setMails($mails);

        $manager->persist($mailing);
    }

    public function load(ObjectManager $manager)
    {
        $this->saveMailing($manager, "liste de diffusion G1", "test1@aa.fr;test2@aa.fr;test3@aa.fr;marvin.ipsos@gmail.com");
        $this->saveMailing($manager, "liste de diffusion G2", "test4@aa.fr;test5@aa.fr;test6@aa.fr;marvin.ipsos@gmail.com");

        $manager->flush();
    }
}
