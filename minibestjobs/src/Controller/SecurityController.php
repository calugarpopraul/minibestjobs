<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/10/18
 * Time: 9:38 AM
 */

namespace App\Controller;


use App\Form\LoginForm;;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{

    /**
     * @Route("/login",name="security_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form=$this->createForm(LoginForm::class,[
            '_username'=>$lastUsername
        ]);

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'form' => $form->createView(),
                'error'         => $error,
            )
        );
    }

}