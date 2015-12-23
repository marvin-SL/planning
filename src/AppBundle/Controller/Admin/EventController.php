<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
        dump($request->request->get('id'));die;
        $editForm = $this->createForm(new EventType(), $entity);

        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_calendar_index'));
        }

        return $this->render('AppBundle:Admin/Event:edit.html.twig', array(
            'edit_form'   => $editForm->createView(),
            'entity' => $entity,
        ));
    }

    public function xmlWriterAction(Request $request)
    {

        $serializer = $this->get('jms_serializer');
        $data = "<event><id>102</id><calendar>groupe 1</calendar><start_date>2015-12-23 14:22:12</start_date><end_date>2015-12-23 17:22:12</end_date><classroom>C343, Copernic (en face des machines)</classroom><notice/><subject>Angais / Trudy</subject></event>";

        $d = $serializer->deserialize($data, 'AppBundle\Entity\Event', 'xml');
        dump($d);die;
        // $serializer = $this->get('app.serializer');
        // $serializer->serializeToXmlAction();

        return $this->redirect($this->generateUrl('admin_calendar_index'));
    }
}
