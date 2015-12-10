<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ClassRoom;
use AppBundle\Form\ClassRoomType;

class ClassRoomController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Admin/classRoom:index.html.twig');
    }

    public function newAction(Request $request)
    {
        $classRoom = new ClassRoom();

        $form = $this->createForm(new ClassRoomType(), $classRoom);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classRoom);
            $em->flush();
        }

        return $this->render('AppBundle:Admin/ClassRoom:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}
