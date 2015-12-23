<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Classroom;


class LoadClassroomData extends AbstractFixture implements OrderedFixtureInterface
{
  /**
  * {@inheritDoc}
  */
  public function load(ObjectManager $manager)
  {
    $classroom1 = new Classroom();
    $classroom2 =  new Classroom();
    $classroom3 =  new Classroom();
        $classroom4 =  new Classroom();

    $classroom1->setName('C343, Copernic (en face des machines)');
    $classroom2->setName('B212 Bois d\'ébène');
    $classroom3->setName('Parking');
    $classroom4->setName('test');

    $this->addReference('classroom1', $classroom1);
    $this->addReference('classroom2', $classroom2);
    $this->addReference('classroom3', $classroom3);
    $this->addReference('classroom4', $classroom4);

    $manager->persist($classroom1);
    $manager->persist($classroom2);
    $manager->persist($classroom3);
    $manager->persist($classroom4);

    $manager->flush();

  }

  /**
    * {@inheritDoc}
    */
   public function getOrder()
   {
       return 3; // the order in which fixtures will be loaded
   }
}
