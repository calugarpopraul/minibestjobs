<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/9/18
 * Time: 9:46 AM
 */

namespace App\Controller;


use App\Form\UserRegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/register",name="user_register")
     */
    public function registerAction(Request $request){

        $form = $this->createForm(UserRegistrationType::class);

        $form->handleRequest($request);



        return $this->render('register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}