<?php

namespace AppBundle\Menu;

use KnpMenuFactoryInterface;
use SymfonyComponentHttpFoundationRequest;

class MenuBuilder
{
   private $factory;

   /**
    * @param FactoryInterface $factory
    */
   public function __construct(FactoryInterface $factory)
   {
       $this->factory = $factory;
   }

   public function createMainMenu(Request $request)
   {
       $menu = $this->factory->createItem('root');

       $menu->addChild('Index', array('route' => 'admin_dashboard'));
       // ... ajoutez ici les autres liens de base

       return $menu;
   }
}
