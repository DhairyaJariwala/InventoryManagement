<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class LoginFormAuthenticator extends AbstractGuardAuthenticator{
    private $entityManager;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;
    
    public function __construct(EntityManagerInterface $em,RouterInterface $router,CsrfTokenManagerInterface $csrfTokenManager,UserPasswordEncoderInterface $passwordEncoder) {
        $this->entityManager = $em;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }
    public function supports(Request $request) {
        return $request->attributes->get('_route') === 'app_login'
                && $request->isMethod('POST');
    }
    public function getCredentials(Request $request) {
        $credentials = [
            'email' => $request->request->get('uname'),
            'password' => $request->request->get('psw'),
            'csrf_token' => $request->request->get('_csrf_token')
        ];
        $request->getSession()->set(
                Security::LAST_USERNAME,
                $credentials['email']
        );
        
        return $credentials;
    }
    public function getUser($credentials, UserProviderInterface $userProvider) {
        $token = new CsrfToken('authenticate',$credentials['csrf_token']);
        if(!$this->csrfTokenManager->isTokenValid($token)){
            throw new InvalidCsrfTokenException();
        }
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);
        if(!$user){
            throw new CustomUserMessageAuthenticationException("Email not Found");
        }
        
        return $user;
        
    }
    public function checkCredentials($credentials, UserInterface $user) {
        if($this->passwordEncoder->isPasswordValid($user, $credentials['password'])){
            return true;
        }
        else{
            throw new CustomUserMessageAuthenticationException("Password is Invalid");
        }
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
        return new RedirectResponse("/dashboard");
    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

       $url = $this->router->generate('app_login');

       return new RedirectResponse($url);
    }
    public function start(Request $request, AuthenticationException $authException = null) {
       return new RedirectResponse('/dashboard');
    }
    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }
    
    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('/dashboard');
    }
    
    public function supportsRememberMe() {
       return false;
    }
}
?>

