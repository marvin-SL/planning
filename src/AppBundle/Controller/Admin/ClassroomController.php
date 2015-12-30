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
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();

        $classrooms = $em->getRepository('AppBundle:Classroom')->findAll();

        if($session->get('introduction') == 'true')
        {

            $session->getFlashBag()->add(
                    'notice',
                    ''
                );

            return $this->render('AppBundle:Admin/Classroom:index.html.twig', array('classrooms'=>$classrooms));

        }

        return $this->render('AppBundle:Admin/Classroom:index.html.twig', array('classrooms'=>$classrooms));
    }

    public function newAction(Request $request)
    {
        $classroom = new Classroom();

        $session = $request->getSession();

        $form = $this->createForm(new ClassroomType(), $classroom);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_classroom_index'));
        }

        if($session->get('introduction') == 'true')
        {

            $session->getFlashBag()->add(
                    'notice',
                    ''
                );

                return $this->render('AppBundle:Admin/Classroom:new.html.twig', array(
                    'form' => $form->createView(),
                ));

        }

        return $this->render('AppBundle:Admin/Classroom:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}
