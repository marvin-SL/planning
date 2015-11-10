<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Subject;


class LoadSubjectData extends AbstractFixture implements OrderedFixtureInterface
{
  /**
  * {@inheritDoc}
  */
  public function load(ObjectManager $manager)
  {
    $subject1 = new Subject();
    $subject2 =  new Subject();
    $subject3 =  new Subject();

    $subject1->setName('Angais');
    $subject2->setName('PHP');
    $subject3->setName('Socio');

    $subject1->setRoom('B212 Bois d\'ébène');
    $subject2->setRoom('C343, Copernic (en face des chiottes)');
    $subject3->setRoom('Parking');

    $subject1->setTeacher('Trudy');
    $subject2->setTeacher('Dyan');
    $subject3->setTeacher('Cardon, Aguiton, Bonzon, Thenoux');

    $this->addReference('subject1', $subject1);
    $this->addReference('subject2', $subject2);
    $this->addReference('subject3', $subject3);

    $manager->flush();

  }

  /**
    * {@inheritDoc}
    */
   public function getOrder()
   {
       return 1; // the order in which fixtures will be loaded
   }
}
