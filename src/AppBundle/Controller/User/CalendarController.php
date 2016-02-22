<?php

namespace AppBundle\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CalendarController extends Controller
{
    public function showAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$entity = $em->getRepository('AppBundle:Calendar')->findOneBy(array('slug' => $slug,))) {
            throw $this->createNotFoundException(sprintf('Unable to find calendar with slug "%s"', $slug));
        };
        
        return $this->render('AppBundle:User/Calendar:show.html.twig', array(
            'entity' => $entity,
        ));
    }
}