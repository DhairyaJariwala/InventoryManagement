<?php

namespace App\Controller;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
//use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends Controller{
    /**
     * @Route("/login",name="app_login")
     */
    public function login(AuthenticationUtils $auth,Request $request){
        $error = $auth->getLastAuthenticationError();
        
        $lastUsername = $auth->getLastUsername();

        return $this->render('security/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    /**
     * @Route("/login_check",name="login_check")
     */
    public function logincheck(){
        
    }
    
    /**
     * @Route("/logout",name="app_logout")
     */
    public function logout(){
        
    }
}
?>

