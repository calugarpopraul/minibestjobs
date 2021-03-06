<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/9/18
 * Time: 9:46 AM
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserRegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/register",name="user_register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){


        //build the form
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);

        //handle the submit on POST
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //encode password
            $password = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);


//            $encoder = $this->get('security.password_encoder');
//            $password = $encoder->encodePassword($user, $user->getPassword());
//            $user->setPassword($password);


            //Set their role
            $user->setRole('ROLE_USER');

            //save user
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('app_login');
        }



        return $this->render('register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}