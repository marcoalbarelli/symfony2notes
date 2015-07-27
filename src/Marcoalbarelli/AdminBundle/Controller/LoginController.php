<?php
/**
 * Created by PhpStorm.
 * User: iksadmin
 * Date: 27/07/15
 * Time: 11.45
 */

namespace Marcoalbarelli\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class LoginController extends Controller
{

    /**
     * @Route(name="admin_login",path="/login")
     * @Template("@MarcoalbarelliAdmin/Security/login.html.twig")
     * @Method("GET")
     */
    public function loginAction(){
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return array(
                'last_username' => $lastUsername,
                'error'         => $error,
            );
    }

    /**
     * @Route(name="admin_login_check",path="/login_check")
     */
    public function loginCheckAction(){
    }

    /**
     * @Route(name="admin_logout",path="/logout")
     */
    public function logoutAction(){

    }
}