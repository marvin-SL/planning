<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ClassRoom;
use AppBundle\Form\ClassRoomType;

class ClassRoomController extends Controller
{
    public function newAction(Request $request)
    {
        // replace this example code with whatever you need
        $clasRoom = new Subject();

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
