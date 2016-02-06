<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Calendar;
use Doctrine\ORM\EntityRepository;

/**
 * EventRepository.
 */
class EventRepository  extends EntityRepository
{
    /**
     * Compte le nombre d'évenement
     * @return [type] [description]
     */
    public function count()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)');

        return $qb->getQuery()->getSingleScalarResult();
    }

        /**
         * Trouve les events d'un calendrier.
         */
    public function findCalendarEvents(Calendar $calendar)
    {
            $qb = $this->createQueryBuilder('e');
            $qb->select('e');
            $qb->leftJoin('e.calendar', 'c');
            $qb->where('c = :calendar');
            $qb->setParameter('calendar', $calendar);

            return $qb->getQuery()->getResult();
    }
}
