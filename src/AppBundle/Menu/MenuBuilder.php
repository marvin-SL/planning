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
        'label' => 'Tableau de bord',
        'extras'    => array('icon'  => 'fa fa-fw fa-dashboard'),
        ));

        $menu->addChild('Teacher', array('route' => 'admin_teacher_index',
        'label' => 'Enseignants',
        'extras'    => array('icon'  => 'fa fa-graduation-cap')
        ));

        $menu->addChild('Subject', array('route' => 'admin_subject_index',
        'label' => 'Matières',
        'extras'    => array('icon'  => 'fa fa-fw fa-language')
        ));

        $menu->addChild('Classroom', array('route' => 'admin_classroom_index',
        'label' => 'Salles',
        'extras'    => array('icon'  => 'fa fa-fw fa-map-marker')
        ));

        $menu->addChild('Planning', array('route' => 'admin_calendar_index',
        'label' => 'Plannings',
        'extras'    => array('icon'  => 'fa fa-fw fa-calendar')
        ));

        $menu->addChild('Users', array('route' => 'admin_user_index',
        'label' => 'Utilisateurs',
        'extras'    => array('icon'  => 'fa fa-users')
        ));

    return $menu;
    }
}
