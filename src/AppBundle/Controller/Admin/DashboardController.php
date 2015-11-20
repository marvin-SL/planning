<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Admin/Dashboard:index.html.twig');
    }

}
