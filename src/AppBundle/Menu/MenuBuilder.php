<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class MenuBuilder
{
   private $factory;
   private $em;

   /**
    * @param FactoryInterface $factory
    */
   public function __construct(FactoryInterface $factory, Entitymanager $em)
   {
       $this->factory = $factory;
       $this->em = $em;
   }

   /**
    * main menu
    *
    * @param Request $request
    *
    * @return FactoryInterface
    */
   public function createMainMenu(Request $request)
   {
       $menu = $this->factory->createItem('root');

       $menu->addChild('Index', array('route' => 'admin_dashboard',
                                      'label' => 'Tableau de bord'
                                  ));
       // ... ajoutez ici les autres liens de base

       return $menu;
   }
}
