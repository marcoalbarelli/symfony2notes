<?php
/**
 * Created by PhpStorm.
 * User: iksadmin
 * Date: 27/07/15
 * Time: 11.45
 */

namespace Marcoalbarelli\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class LoginController extends Controller
{

    /**
     * @Route(name="admin_login",path="/login")
     * @Template("@MarcoalbarelliAdmin/Security/login.html.twig")
     */
    public function loginAction(){
        return array();
    }

}