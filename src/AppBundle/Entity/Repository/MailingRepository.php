<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TeacherRepository
 *
 */
class MailingRepository extends EntityRepository
{
    /**
     * Count number of Mailing entity
     * @return [type] [description]
     */
    public function count()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
