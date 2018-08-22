<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/10/18
 * Time: 10:18 AM
 */

namespace App\Security;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $router;
    private $encoder;
    private $security;

    public function __construct(RouterInterface $router,UserPasswordEncoderInterface $encoder,
        Security $security)
    {
        $this->router = $router;
        $this->encoder = $encoder;
        $this->security = $security;
    }

    public function getCredentials(Request $request)
    {
        $login_array = $request->request->get('login_form');
        $email = $login_array['_username'];
        $password = $login_array['_password'];
        if(!empty($email)){
            $request->getSession()->set(Security::LAST_USERNAME, $request->get('_username'));

            return array(
                'username'=>$email,
                'password'=>$password
            );
        }
        return [];

    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {

        if(empty($credentials)){
            return null;
        }
        $email = null;
        if(array_key_exists('username',$credentials)){
            $email = $credentials['username'];

        }
        if(null === $email || empty($email)){
            return null;
        }
        $user = $userProvider->loadUserByUsername($email);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        if ($this->encoder->isPasswordValid($user, $plainPassword)) {
            return true;
        }

        throw new BadCredentialsException();
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->router->generate('app_homepage');

        return new RedirectResponse($url);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        $url = $this->router->generate('app_login');

        return new RedirectResponse($url);
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('app_homepage');
    }

    public function supports(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo()===$this->router->generate('app_login')
            && $request->isMethod('POST');

        if(!$isLoginSubmit){
            return [];
        }

        if($this->security->getUser()){
            return false;
        }

        return true;

    }


}