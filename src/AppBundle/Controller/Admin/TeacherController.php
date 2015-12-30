<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Teacher;
use AppBundle\Form\TeacherType;
use Symfony\Component\HttpFoundation\Session\Session;

class TeacherController extends Controller
{

    public function indexAction(Request $request)
    {
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();

        $teachers = $em->getRepository('AppBundle:Teacher')->findAll();

        if($session->get('introduction') == 'true')
        {

            $session->getFlashBag()->add(
                    'notice',
                    ''
                );

            return $this->render('AppBundle:Admin/Teacher:index.html.twig', array('teachers'=>$teachers));

        }

        return $this->render('AppBundle:Admin/Teacher:index.html.twig', array('teachers'=>$teachers));
    }

    public function newAction(Request $request)
    {
        $teacher = new Teacher();

        $session = $request->getSession();

        $form = $this->createForm(new TeacherType(), $teacher);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_teacher_index'));
        }

        if($session->get('introduction') == 'true')
        {

            $session->getFlashBag()->add(
                    'notice',
                    ''
                );

                return $this->render('AppBundle:Admin/Teacher:new.html.twig', array(
                    'form' => $form->createView(),
                ));
        }

        return $this->render('AppBundle:Admin/Teacher:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}
