<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Teacher;
use Doctrine\ORM\EntityRepository;

/**
 * SubjectRepository
 *
 */
class SubjectRepository  extends EntityRepository
{
    /**
     * Trouve les enseignants relatifs à une matière
    */
    public function findTeachersSubject(Teacher $teacher)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->leftJoin('s.teachers', 't');
        $qb->where('t = :teachers');
        $qb->setParameter('teachers', $teacher);


        return $qb->getQuery()->getResult();
    }
}
