<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;

class EventController extends Controller
{
    public function newAction(Request $request)
    {
        // replace this example code with whatever you need
        $event = new Event();

        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);

        $serializer = $this->get('app.manager.customSerializer');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $message = $this->get('translator')->trans('event.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            $serializer->serialize($event->getCalendar());
        }

        return $this->render('AppBundle:Admin/Event:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$entity = $em->getRepository('AppBundle:Event')->find($id)) {
            throw $this->createNotFoundException(sprintf('Unable to find event with id "%s"', $id));
        }

        $path = $this->get('kernel')->getRootDir().'/../web/data/debug.xml';

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EventType(), $entity);

        $serializer = $this->get('app.manager.customSerializer');

        $calendar = $entity->getCalendar();

        $slug = $calendar->getSlug();

        if ($request->isMethod('POST')) {
            $editForm->handleRequest($request);

            if ($request->isXmlHttpRequest()) {
                $startDate = $request->request->get('start_date');
                $endDate = $request->request->get('end_date');

                $entity->setStartDate(new \DateTime($startDate));
                $entity->setEndDate(new \DateTime($endDate));
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $serializer->serialize($calendar);
            } else {
                if ($editForm->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();
                    $serializer->serialize($calendar);

                    $message = $this->get('translator')->trans('event.create_success', array(), 'flashes');
                    $this->get('session')->getFlashBag()->add('success', $message);

                    return $this->redirect($this->generateUrl('admin_calendar_show', array('slug' => $slug)));
                }

                return $this->redirect($this->generateUrl('admin_calendar_index'));
            }
        }

        return $this->render('AppBundle:Admin/Event:edit.html.twig', array(
           'edit_form' => $editForm->createView(),
           'delete_form' => $deleteForm->createView(),
           'entity' => $entity,
        ));
    }

    /**
     * Deletes a Event entity.
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
            if (!$entity = $em->getRepository('AppBundle:Event')->find($id)) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }

            $em->remove($entity);
            $em->flush();
            $calendar = $entity->getCalendar();

            $message = $this->get('translator')->trans('event.delete_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);
        }

        return $this->redirect($this->generateUrl('admin_calendar_edit', array('slug' => $calendar->getSlug())));
    }

    /**
     * Creates a form to delete a Event entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_event_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'button.delete', 'translation_domain' => 'forms'))
            ->getForm();
    }
}
