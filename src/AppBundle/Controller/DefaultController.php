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

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Show default user view
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function indexAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");

        $breadcrumbs->addRouteItem("Accueil", "index");

        $em = $this->getDoctrine()->getManager();

        if (!$entities = $em->getRepository('AppBundle:Calendar')->findAll()) {
            throw $this->createNotFoundException(sprintf('Unable to find calendars'));
        };

        return $this->render('AppBundle:Default:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * [mobileIndexAction description]
     * @param  Request $request [description]
     * @param  [type]  $slug    [description]
     * @return [type]           [description]
     */
     public function indexMobileAction(Request $request)
     {
         $breadcrumbs = $this->get("white_october_breadcrumbs");

         $breadcrumbs->addRouteItem("Accueil", "index");

         $em = $this->getDoctrine()->getManager();

         if (!$entities = $em->getRepository('AppBundle:Calendar')->findAll()) {
             throw $this->createNotFoundException(sprintf('Unable to find calendars'));
         };

         return $this->render('AppBundle:Default:indexMobile.html.twig', array(
             'entities' => $entities
         ));
     }
}
