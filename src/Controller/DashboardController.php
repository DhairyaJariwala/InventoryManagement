<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends Controller{
    /**
     * @Route("/dashboard",name="dashboard")
     */
    public function dashboard(Request $request){
        return $this->render("base.html.twig");
    }
    
    /**
     * @Route("/",name="default")
     */
    public function index(Request $request){
        return $this->redirectToRoute('dashboard');
    }
    
    /**
     * @Route("/registration",name="register")
     */
    public function register(Request $request){
        $user = new User();
        $registerForm = $this->createForm(RegistrationType::class,$user);
        
        $registerForm->handleRequest($request);
        
        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $user = $registerForm->getData();
            $encoder = $this->get('security.password_encoder');
            $pwd = $user->getPlainPassword();
            $password = $encoder->encodePassword($user,$pwd);
            $user->setPassword($password);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('app_login');
        }
        return $this->render('Registration/registration.html.twig',['registerForm' => $registerForm->createView()]);
    }
}

