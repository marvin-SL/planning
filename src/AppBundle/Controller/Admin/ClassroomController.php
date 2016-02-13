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
use AppBundle\Entity\Classroom;
use AppBundle\Form\ClassroomType;

class ClassroomController extends Controller
{
    /**
    * List of classrooms
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $classrooms = $em->getRepository('AppBundle:Classroom')->findAll();

        return $this->render('AppBundle:Admin/Classroom:index.html.twig', array(
            'classrooms' => $classrooms,
        ));
    }

    /**
    * Create a new Classroom entity
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function newAction(Request $request)
    {
        $classroom = new Classroom();

        $session = $request->getSession();

        $form = $this->createForm(new ClassroomType(), $classroom);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();

            $message = $this->get('translator')->trans('classroom.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_classroom_index'));
        }

        return $this->render('AppBundle:Admin/Classroom:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
    * Edit a Classroom Entity by id
    * @param  Request $request [description]
    * @param  [type]  $id      [description]
    * @return [type]           [description]
    */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$entity = $em->getRepository('AppBundle:Classroom')->find($id)) {
            throw $this->createNotFoundException(sprintf('Unable to find classroom with id "%s"', $id));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ClassroomType(), $entity);
        $editForm->handleRequest($request);

        $classrooms = $em->getRepository('AppBundle:Classroom')->findAll();

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $message = $this->get('translator')->trans('classroom.update_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_classroom_index'));
        }

        return $this->render('AppBundle:Admin/Classroom:edit.html.twig', array(
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entity' => $entity,
            'classrooms' => $classrooms,
        ));
    }

    /**
    * Deletes a Classroom entity by id
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

        if ($form->handleRequest($request)->isValid()) {
            if (!$entity = $em->getRepository('AppBundle:Classroom')->find($id)) {
                throw $this->createNotFoundException('Unable to find Classroom entity.');
            }

            $em->remove($entity);
            $em->flush();

            $message = $this->get('translator')->trans('classroom.delete_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);
        }

        return $this->redirect($this->generateUrl('admin_classroom_index'));
    }

    /**
    * Creates a form to delete a Classroom entity by id.
    *
    * @param mixed $id The entity id
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('admin_classroom_delete', array('id' => $id)))
        ->setMethod('DELETE')
        ->add('submit', 'submit', array('label' => 'button.delete', 'translation_domain' => 'forms'))
        ->getForm();
    }
}
