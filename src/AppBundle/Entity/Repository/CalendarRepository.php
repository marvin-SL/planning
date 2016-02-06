<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Classroom;
use Doctrine\ORM\EntityRepository;

/**
 * CalendarRepository
 *
 */
class CalendarRepository extends EntityRepository
{
    /**
     * Compte le nombre de calendrier
     * @return [type] [description]
     */
    public function count()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
