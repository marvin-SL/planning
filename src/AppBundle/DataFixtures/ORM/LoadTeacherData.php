<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Teacher;


class LoadTeacherData extends AbstractFixture implements OrderedFixtureInterface
{
  /**
  * {@inheritDoc}
  */
  public function load(ObjectManager $manager)
  {
    $teacher1 = new Teacher();
    $teacher2 =  new Teacher();
    $teacher3 =  new Teacher();

    $teacher1->setFirstname('Trudy');
    $teacher1->setLastname('Julian');

    $teacher2->setFirstname('Dominique');
    $teacher2->setLastname('Cardon');

    $teacher3->setFirstname('Thierry');
    $teacher3->setLastname('Bonzon');

    $this->addReference('teacher1', $teacher1);
    $this->addReference('teacher2', $teacher2);
    $this->addReference('teacher3', $teacher3);

    $manager->persist($teacher1);
    $manager->persist($teacher2);
    $manager->persist($teacher3);

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
