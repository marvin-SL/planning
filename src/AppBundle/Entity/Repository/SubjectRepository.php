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
     * Compte le nombre de matière
     * @return [type] [description]
     */
    public function count()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)');

        return $qb->getQuery()->getSingleScalarResult();
    }

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
