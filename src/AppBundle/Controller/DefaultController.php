<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:index.html.twig');
    }

    public function xmlWriterAction(Request $request)
    {
        $data = $request->request->get("data");
        file_put_contents("./public/events.xml",$data);
        // $event = new Event();
        // $event->setNotice("test");
        //
        // $encoders = array(new XmlEncoder(), new JsonEncoder());
        // $normalizers = array(new ObjectNormalizer());
        //
        // $serializer = new Serializer($normalizers, $encoders);
        //
        // $xmlContent = $serializer->serialize($event, 'xml');
        //
        // var_dump($xmlContent);die;

        return $this->redirect($this->generateUrl('index'));
    }
}
