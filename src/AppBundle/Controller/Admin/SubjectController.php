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

            $message = $this->get('translator')->trans('subject.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

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
    public function editAction(Request $request, $id)
    {
         $em = $this->getDoctrine()->getManager();

         $entity = $em->getRepository('AppBundle:Subject')->find($id);

         $path = $this->get('kernel')->getRootDir() . '/../web/data/debug.xml';

         $deleteForm = $this->createDeleteForm($id);
         $editForm = $this->createForm(new SubjectType(), $entity);

         $serializer  = $this->get('app.manager.customSerializer');

         $calendars = $em->getRepository('AppBundle:Calendar')->findAll();

         $subjects = $em->getRepository('AppBundle:Subject')->findAll();

        if ($request->isMethod('POST'))
         {
            $editForm->handleRequest($request);

            if($request->isXmlHttpRequest())
            {

                $startDate = $request->request->get('start_date');
                $endDate = $request->request->get('end_date');

                $entity->setStartDate(new \DateTime($startDate));
                $entity->setEndDate(new \DateTime($endDate));
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $serializer->serialize($calendars);
            }

            else
            {
                if($editForm->isValid()){
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();
                    foreach ($calendars as $calendar) {
                        $serializer->serializeToXmlAction($calendar);
                    }


                    $message = $this->get('translator')->trans('subject.update_success', array(), 'flashes');
                    $this->get('session')->getFlashBag()->add('success', $message);

                    return $this->redirect($this->generateUrl('admin_subject_index'));
                }
                 return $this->redirect($this->generateUrl('admin_subject_index'));

            }

        }

        return $this->render('AppBundle:Admin/Subject:edit.html.twig', array(
           'edit_form'   => $editForm->createView(),
           'delete_form' => $deleteForm->createView(),
           'entity' => $entity,
           'subjects' => $subjects,
        ));
    }


        /**
         * Deletes a Subject entity.
         *
         * @param Request $request
         * @param integer $id
         *
         * @return Symfony\Component\HttpFoundation\Response
         */
        public function deleteAction(Request $request, $id)
        {
            $em = $this->getDoctrine()->getManager();
            $form = $this->createDeleteForm($id);


            if ($form->handleRequest($request)->isValid()) {

                if (!$entity = $em->getRepository('AppBundle:Subject')->find($id)) {
                    throw $this->createNotFoundException('Unable to find Subject entity.');
                }

                $em->remove($entity);
                $em->flush();

                $message = $this->get('translator')->trans('subject.delete_success', array(), 'flashes');
                $this->get('session')->getFlashBag()->add('success', $message);
            }

            return $this->redirect($this->generateUrl('admin_subject_index'));
        }

        /**
         * Creates a form to delete a Subject entity by id.
         *
         * @param mixed $id The entity id
         *
         * @return \Symfony\Component\Form\Form The form
         */
        private function createDeleteForm($id)
        {
            return $this->createFormBuilder()
                ->setAction($this->generateUrl('admin_subject_delete', array('id' => $id)))
                ->setMethod('DELETE')
                ->add('submit', 'submit', array('label' => 'button.delete', 'translation_domain' => 'forms'))
                ->getForm();
        }

    }
