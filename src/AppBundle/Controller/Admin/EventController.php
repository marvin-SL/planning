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

    public function xmlWriterAction(Request $request)
    {
        $data = $request->request->get("data");

        // var_dump(dirname("web/bundles/app/events.xml"));die;

        $path = $this->get('kernel')->getRootDir() . '/../web/data/events.xml';

        file_put_contents($path,$data);
        $event = new Event();

        $event->setNotice("test");

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $xmlContent = $serializer->serialize($event, 'xml');




        return $this->redirect($this->generateUrl('admin_calendar_show'));
    }
}
