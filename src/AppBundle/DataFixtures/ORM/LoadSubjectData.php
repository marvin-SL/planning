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
    $subject1->setRoom('B212 Bois d\'ébène');
    $subject1->setTeachers($this->getReference('teacher1'));

    $subject2->setName('PHP');
    $subject2->setRoom('C343, Copernic (en face des chiottes)');
    $subject1->setTeachers($this->getReference('teacher2'));

    $subject3->setName('Socio');
    $subject3->setRoom('Parking');
    $subject1->setTeachers($this->getReference('teacher3'));

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
    return 2; // the order in which fixtures will be loaded
  }
}
