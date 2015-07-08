<?php

namespace Marcoalbarelli\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}", name="api_hello")
     */
    public function indexAction($name)
    {
        return new Response(json_encode(array('hello'=>$name)));
    }
}
