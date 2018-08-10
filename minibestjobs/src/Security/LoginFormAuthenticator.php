<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/10/18
 * Time: 10:18 AM
 */

namespace App\Security;

use App\Form\LoginForm;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    private $formFactory;
    private $em;
    private $router;

//    public function __construct(FormFactoryInterface $formFactory, EntityManager $em,RouterInterface $router)
//    {
//        $this->formFactory = $formFactory;
//
//        $this->em = $em;
//        $this->router = $router;
//    }

    public function supports(Request $request)
    {
        // TODO: Implement supports() method.
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo()=='/login' && $request->isMethod('POST');

        if(!$isLoginSubmit){
            return;
        }

        $form=$this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
        $data = $form->getData();

        return $data;

    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        return $this->em->getRepository('App/Entity/User')
            ->findOneBy(['email'=>$username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

        if($password=='iliketurtles'){
            return true;
        }

        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return $this->router->generate('app_homepage');
    }


}