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

            $message = $this->get('translator')->trans('teacher.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

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

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Teacher')->find($id);

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TeacherType(), $entity);
        $editForm->handleRequest($request);

        $teachers = $em->getRepository('AppBundle:Teacher')->findAll();

        if($editForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $message = $this->get('translator')->trans('teacher.update_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_teacher_index'));
        }

        return $this->render('AppBundle:Admin/Teacher:edit.html.twig', array(
           'edit_form'   => $editForm->createView(),
          // 'delete_form' => $deleteForm->createView(),
           'entity' => $entity,
           'teachers' => $teachers,
        ));
    }

    /**
     * Deletes a Teacher entity.
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

            if (!$entity = $em->getRepository('AppBundle:Teacher')->find($id)) {
                throw $this->createNotFoundException('Unable to find Teacher entity.');
            }

            $em->remove($entity);
            $em->flush();

            $message = $this->get('translator')->trans('teacher.delete_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);
        }

        return $this->redirect($this->generateUrl('admin_teacher_index'));
    }

    /**
     * Creates a form to delete a Teacher entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_teacher_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'button.delete', 'translation_domain' => 'forms'))
            ->getForm();
    }
}
