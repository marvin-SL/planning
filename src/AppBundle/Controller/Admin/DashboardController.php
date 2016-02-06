<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard index
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function indexAction(Request $request)
    {
        $calendars['values'] = $this->getDoctrine()
        ->getRepository('AppBundle:Calendar')->findBy(array(), array('createdAt' => 'DESC'), 5);
        $classrooms['values'] = $this->getDoctrine()
        ->getRepository('AppBundle:Classroom')->findBy(array(), array('createdAt' => 'DESC'), 5);
        $subjects['values'] = $this->getDoctrine()
        ->getRepository('AppBundle:Subject')->findBy(array(), array('createdAt' => 'DESC'), 5);
        $teachers['values'] = $this->getDoctrine()
        ->getRepository('AppBundle:Teacher')->findBy(array(), array('createdAt' => 'DESC'), 5);
        $users['values'] = $this->getDoctrine()
        ->getRepository('AppBundle:User')->findBy(array(), array('createdAt' => 'DESC'), 5);

        $calendars['count'] = $this->getDoctrine()
        ->getRepository('AppBundle:Calendar')->count();
        $classrooms['count'] = $this->getDoctrine()
        ->getRepository('AppBundle:Classroom')->count();
        $subjects['count'] = $this->getDoctrine()
        ->getRepository('AppBundle:Subject')->count();
        $teachers['count'] = $this->getDoctrine()
        ->getRepository('AppBundle:Teacher')->count();
        $users['count'] = $this->getDoctrine()
        ->getRepository('AppBundle:User')->count();

        return $this->render('AppBundle:Admin/Dashboard:index.html.twig', array(
            "calendars" => $calendars,
            "classrooms" => $classrooms,
            "subjects" => $subjects,
            "teachers" => $teachers,
            "users" => $users,
        ));
    }
}
