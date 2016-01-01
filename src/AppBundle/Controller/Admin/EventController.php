<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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


        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        }

        return $this->render('AppBundle:Admin/Event:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function editAction(Request $request, $id)
    {
         $em = $this->getDoctrine()->getManager();

         $entity = $em->getRepository('AppBundle:Event')->find($id);

         $path = $this->get('kernel')->getRootDir() . '/../web/data/debug.xml';

         $startDate = $request->request->get('start_date');
         $endDate = $request->request->get('end_date');

         $editForm = $this->createForm(new EventType(), $entity);

         $serializer  = $this->get('app.serializer');

         $calendar = $entity->getCalendar();

          $slug = $calendar->getSlug();

        if ($request->isMethod('POST'))
         {
            $editForm->handleRequest($request);

            if($request->isXmlHttpRequest())
            {
                $entity->setStartDate(new \DateTime($startDate));
                $entity->setEndDate(new \DateTime($endDate));
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $serializer->serializeToXmlAction($calendar);
            }

            else
            {
                if($editForm->isValid()){
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();
                    $serializer->serializeToXmlAction($calendar);

                    return $this->redirect($this->generateUrl('admin_calendar_show', array('slug' => $slug)));
                }
                 return $this->redirect($this->generateUrl('admin_calendar_index'));

            }

        }

        return $this->render('AppBundle:Admin/Event:edit.html.twig', array(
           'edit_form'   => $editForm->createView(),
           'entity' => $entity,
        ));
    }

}
