<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Classroom;
use Doctrine\ORM\EntityRepository;

/**
 * TeacherRepository
 *
 */
class TeacherRepository extends EntityRepository
{
    /**
     * Compte le nombre de prof
     * @return [type] [description]
     */
    public function count()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
