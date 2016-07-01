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
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventController extends Controller
{
    /**
    * Create a new Event entity
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event = new Event();
        $form = $this->createForm(new EventType(), $event);

        $serializer = $this->get('app.manager.customSerializer');

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($request->isXmlHttpRequest()) {
                $event = new Event();
                $subject = $request->request->get('subject');
                preg_match('/^[0-9A-Za-z]+/', $subject, $matches);

                $startDate = $request->request->get('start_date');
                $endDate = $request->request->get('end_date');

                $event->setStartDate(new \DateTime($startDate));
                $event->setEndDate(new \DateTime($endDate));
                $event->setNotice($request->request->get('notice'));
                $event->setCalendar($em->getRepository('AppBundle:Calendar')->findOneBy(array(
                    'title' => $request->request->get('calendar')
                )));
                $event->setSubject($em->getRepository('AppBundle:Subject')->findOneBy(array(
                    'name' => $matches
                )));
                $event->setClassroom($em->getRepository('AppBundle:Classroom')->findOneBy(array(
                    'name' => $request->request->get('classroom'))));
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                $serializer->serialize($em->getRepository('AppBundle:Calendar')->findOneBy(array(
                    'title' => $request->request->get('calendar')
                )));
            } else {

                if ($form->isValid()) {

                    $event->getCalendar()->setLastEventEditedAt(new \DateTime('now'));
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($event);
                    $em->flush();

                    $message = $this->get('translator')->trans('event.create_success', array(), 'flashes');
                    $this->get('session')->getFlashBag()->add('success', $message);

                    $serializer->serialize($event->getCalendar());

                    return $this->redirect($this->generateUrl('admin_calendar_edit', array('slug' => $event->getCalendar()->getSlug())));
                }
            }

        }
        return $this->render('AppBundle:Admin/Event:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
    * Edit an Event entity by id
    * @param  Request $request [description]
    * @param  [type]  $id      [description]
    * @return [type]           [description]
    */
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
                $calendar->setLastEventEditedAt(new \DateTime('now'));
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $serializer->serialize($calendar);

                return new JsonResponse(array('test' => 'test'));
        
            } else {
                if ($editForm->isValid()) {
                    $calendar->setLastEventEditedAt(new \DateTime('now'));
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();
                    $serializer->serialize($calendar);

                    $message = $this->get('translator')->trans('event.update_success', array(), 'flashes');
                    $this->get('session')->getFlashBag()->add('success', $message);

                    return $this->redirect($this->generateUrl('admin_calendar_edit', array('slug' => $entity->getCalendar()->getSlug())));
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
    * Deletes a Event entity by id
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
            $serializer = $this->get('app.manager.customSerializer')->serialize($calendar, true);
            $serializer = $this->get('app.manager.customSerializer')->serialize($calendar);

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
