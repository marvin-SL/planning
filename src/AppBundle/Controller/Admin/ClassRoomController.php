<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Classroom;
use AppBundle\Form\ClassroomType;

class ClassroomController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Admin/classroom:index.html.twig');
    }

    public function newAction(Request $request)
    {
        $classroom = new Classroom();

        $form = $this->createForm(new ClassroomType(), $classroom);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
        }

        return $this->render('AppBundle:Admin/Classroom:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}
