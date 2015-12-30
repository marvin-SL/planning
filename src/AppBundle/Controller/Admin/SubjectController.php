<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Subject;
use AppBundle\Form\SubjectType;

class SubjectController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $subjects = $em->getRepository('AppBundle:Subject')->findAll();

        $session = $request->getSession();
//
// $results = [];
//     foreach ($subjects as $subject) {
//          $results[]['name'] = $subject->getName();
//
//         foreach ($subject->getTeachers() as $teacher){
//
//              $results[]['teacher_firstname'] = $teacher->getFirstname();
//              $results[]['teacher_lastname'] = $teacher->getLastname();
//         }
//      }

// dump($subjects);die;

if($session->get('introduction') == 'true')
{

    $session->getFlashBag()->add(
            'notice',
            ''
        );

        return $this->render('AppBundle:Admin/Subject:index.html.twig', array(
            'subjects' =>$subjects
        ));
}


        return $this->render('AppBundle:Admin/Subject:index.html.twig', array(
            'subjects' =>$subjects
        ));
    }

    public function newAction(Request $request)
    {
        // replace this example code with whatever you need
        $subject = new Subject();

        $session = $request->getSession();

        $form = $this->createForm(new SubjectType(), $subject);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_subject_index'));
        }

        if($session->get('introduction') == 'true')
        {

            $session->getFlashBag()->add(
                    'notice',
                    ''
                );
            $session->remove('introduction');

            return $this->render('AppBundle:Admin/Subject:new.html.twig', array(
                'form' => $form->createView(),
            ));
        }


        return $this->render('AppBundle:Admin/Subject:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}
