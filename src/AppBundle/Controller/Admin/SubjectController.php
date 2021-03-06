<?php
/**
* AccountController Doc Comment
*
* PHP version 5.5.9
*
* @author Sainte-Luce Marvin <marvin.sainteluce@gmail.com>
* @link   https://github.com/marvin-SL/planning
*
*/

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Subject;
use AppBundle\Form\SubjectType;

class SubjectController extends Controller
{
    /**
    * Show all Subject entities
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $subjects = $em->getRepository('AppBundle:Subject')->findAll();

        $session = $request->getSession();

        return $this->render('AppBundle:Admin/Subject:index.html.twig', array(
            'subjects' => $subjects,
        ));
    }

    /**
    * Create a new Subject entity
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function newAction(Request $request)
    {
        $subject = new Subject();

        $session = $request->getSession();

        $form = $this->createForm(new SubjectType(), $subject);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

            $message = $this->get('translator')->trans('subject.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_subject_index'));
        }

        return $this->render('AppBundle:Admin/Subject:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
    * Edit an Subject entity by id
    * @param  Request $request [description]
    * @param  [type]  $id      [description]
    * @return [type]           [description]
    */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$entity = $em->getRepository('AppBundle:Subject')->find($id)) {
            throw $this->createNotFoundException(sprintf('Unable to find subject with id "%s"', $id));
        }

        $path = $this->get('kernel')->getRootDir().'/../web/data/debug.xml';

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SubjectType(), $entity);

        $serializer = $this->get('app.manager.customSerializer');

        $calendars = $em->getRepository('AppBundle:Calendar')->findAll();

        $subjects = $em->getRepository('AppBundle:Subject')->findAll();

        if ($request->isMethod('POST')) {
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                foreach ($calendars as $calendar) {
                    $serializer->serialize($calendar);
                }

                $message = $this->get('translator')->trans('subject.update_success', array(), 'flashes');
                $this->get('session')->getFlashBag()->add('success', $message);

                return $this->redirect($this->generateUrl('admin_subject_index'));
            }

            return $this->redirect($this->generateUrl('admin_subject_index'));

        }

        return $this->render('AppBundle:Admin/Subject:edit.html.twig', array(
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entity' => $entity,
            'subjects' => $subjects,
        ));
    }

    /**
    * Deletes a Subject entity by id.
    *
    * @param Request $request
    * @param int     $id
    *
    * @return Symfony\Component\HttpFoundation\Response
    */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($id);
        $serializer = $this->get('app.manager.customSerializer');
        $calendars = $em->getRepository('AppBundle:Calendar')->findAll();

        if ($form->handleRequest($request)->isValid()) {
            if (!$entity = $em->getRepository('AppBundle:Subject')->find($id)) {
                throw $this->createNotFoundException('Unable to find Subject entity.');
            }

            $em->remove($entity);
            $em->flush();
            foreach ($calendars as $calendar) {
                $serializer->serialize($calendar);
            }

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
