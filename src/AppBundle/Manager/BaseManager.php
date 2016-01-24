<?php

namespace AppBundle\Manager;

/**
 * Base manager
 */
abstract class BaseManager
{
    /**
     * Persist and flush the given entity
     *
     * @param mixed $entity
     */
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
