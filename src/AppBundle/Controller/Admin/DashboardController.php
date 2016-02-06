<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {
        $calendars = $this->getDoctrine()
        ->getRepository('AppBundle:Calendar')->findBy(array('id' => 'DESC'));
        $classrooms = $this->getDoctrine()
        ->getRepository('AppBundle:Classroom')->findAll();
        $subjects = $this->getDoctrine()
        ->getRepository('AppBundle:Subject')->findAll();
        $teachers = $this->getDoctrine()
        ->getRepository('AppBundle:Teacher')->findAll();
        $users = $this->getDoctrine()
        ->getRepository('AppBundle:User')->findAll();


        return $this->render('AppBundle:Admin/Dashboard:index.html.twig', array(
            "calendars" => $calendars,
            "classrooms" => $classrooms,
            "subjects" => $subjects,
            "teachers" => $teachers,
            "users" => $users,
        ));
    }

}
