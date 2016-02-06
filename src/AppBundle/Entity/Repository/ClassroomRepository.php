<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Classroom;
use Doctrine\ORM\EntityRepository;

/**
 * ClassroomRepository
 *
 */
class ClassroomRepository extends EntityRepository
{
    /**
     * Compte le nombre de salle
     * @return [type] [description]
     */
    public function count()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
