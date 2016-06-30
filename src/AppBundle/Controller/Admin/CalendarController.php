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
use AppBundle\Entity\Calendar;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use AppBundle\Form\CalendarType;
use Symfony\Component\HttpFoundation\Session\Session;

class CalendarController extends Controller
{
    /**
    * List of Calendar entity
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function indexAction(Request $request)
    {
        $calendars = $this->getDoctrine()
        ->getRepository('AppBundle:Calendar')->findAll();

        return $this->render('AppBundle:Admin/Calendar:index.html.twig', array(
            'calendars' => $calendars,
        ));
    }

    /**
    * Create a new Calendar Entity
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'This user does not have access to this section.');

        $calendar = new Calendar();

        $serializer = $this->get('app.manager.customSerializer');

        $form = $this->createForm(new CalendarType(), $calendar);

        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isValid()) {

            if ($calendarToCopy = $em->getRepository('AppBundle:Calendar')->find($calendar->getModele())) {
                $calendar = clone $calendarToCopy;
                $calendar->setTitle($form->get('title')->getData());
                $calendar->setSlug(null);

                foreach ($calendarToCopy->getEvents() as $eventToCopy) {
                    $event = new Event();
                    $event = clone $eventToCopy;
                    $event->setCalendar($calendar);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($event);
                    $em->flush();
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->persist($event);
            $em->flush();

            $serializer->createEmptyXmlFile($calendar);
            $serializer->serialize($calendar);


            $message = $this->get('translator')->trans('calendar.create_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_calendar_index'));
        }

        return $this->render('AppBundle:Admin/Calendar:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
    * Show a Calendar Entity by slug
    * @param  Request $request [description]
    * @param  [type]  $slug    [description]
    * @return [type]           [description]
    */
    public function showAction(Request $request, $slug)
    {
        $event = new Event();

        $em = $this->getDoctrine()->getManager();
        if (!$entity = $em->getRepository('AppBundle:Calendar')->findOneBy(array('slug' => $slug,))) {
            throw $this->createNotFoundException(sprintf('Unable to find calendar with slug "%s"', $slug));
        };
        $event->setCalendar($entity);
        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $fileCache = $this->container->get('twig')->getCacheFilename('AppBundle:User/Calendar:mobile.html.twig');
            if (is_file($fileCache)) {
                unlink($fileCache);
            }

            $event->getCalendar()->setLastEventEditedAt(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $serializer = $this->get('app.manager.customSerializer')->serialize($entity);

            return $this->redirect($this->generateUrl('admin_calendar_show', array(
                'slug' => $slug
            )));
        }

        return $this->render('AppBundle:Admin/Calendar:show.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
    * Edit a Calendar Entity by slug
    * @param  Request $request [description]
    * @param  [type]  $slug    [description]
    * @return [type]           [description]
    */
    public function editAction(Request $request, $slug)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'This user does not have access to this section.');

        $serializer = $this->get('app.manager.customSerializer');

        $em = $this->getDoctrine()->getManager();

        if (!$entity = $em->getRepository('AppBundle:Calendar')->findOneBy(array('slug' => $slug,))) {
            throw $this->createNotFoundException(sprintf('Unable to find calendar with slug "%s"', $slug));
        };

        $oldSlug = $entity->getSlug();

        $deleteForm = $this->createDeleteForm($slug);
        $editForm = $this->createForm(new CalendarType(), $entity);
        $editForm->handleRequest($request);

        $events = $em->getRepository('AppBundle:Event')->findCalendarEvents($entity);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $serializer->editFileName($entity, $oldSlug);

            $message = $this->get('translator')->trans('calendar.update_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);

            return $this->redirect($this->generateUrl('admin_calendar_index'));
        }

        return $this->render('AppBundle:Admin/Calendar:edit.html.twig', array(
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'entity' => $entity,
            'events' => $events,
        ));
    }

    /**
    * Deletes a Calendar entity by slug.
    *
    * @param Request $request
    * @param int     $id
    *
    * @return Symfony\Component\HttpFoundation\Response
    */
    public function deleteAction(Request $request, $slug)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'This user does not have access to this section.');

        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($slug);

        if ($form->handleRequest($request)->isValid()) {
            if (!$entity = $em->getRepository('AppBundle:Calendar')->findOneBy(array('slug' => $slug))) {
                throw $this->createNotFoundException('Unable to find Calendar entity.');
            }

            $em->remove($entity);
            $em->flush();
            $serializer = $this->get('app.manager.customSerializer')->serialize($entity, true);

            $message = $this->get('translator')->trans('calendar.delete_success', array(), 'flashes');
            $this->get('session')->getFlashBag()->add('success', $message);
        }

        return $this->redirect($this->generateUrl('admin_calendar_index'));
    }

    /**
    * Creates a form to delete a Calendar entity by slug.
    *
    * @param mixed $id The entity id
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('admin_calendar_delete', array('slug' => $slug)))
        ->setMethod('DELETE')
        ->add('submit', 'submit', array('label' => 'button.delete', 'translation_domain' => 'forms'))
        ->getForm();
    }
}
