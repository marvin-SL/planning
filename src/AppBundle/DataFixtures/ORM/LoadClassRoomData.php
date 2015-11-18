<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\ClassRoom;


class LoadClassRoomData extends AbstractFixture implements OrderedFixtureInterface
{
  /**
  * {@inheritDoc}
  */
  public function load(ObjectManager $manager)
  {
    $classRoom1 = new ClassRoom();
    $classRoom2 =  new ClassRoom();
    $classRoom3 =  new ClassRoom();
        $classRoom4 =  new ClassRoom();

    $classRoom1->setName('C343, Copernic (en face des chiottes)');
    $classRoom2->setName('B212 Bois d\'ébène');
    $classRoom3->setName('Parking');
    $classRoom4->setName('test');

    $this->addReference('classRoom1', $classRoom1);
    $this->addReference('classRoom2', $classRoom2);
    $this->addReference('classRoom3', $classRoom3);
    $this->addReference('classRoom4', $classRoom4);

    $manager->persist($classRoom1);
    $manager->persist($classRoom2);
    $manager->persist($classRoom3);
    $manager->persist($classRoom4);

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
