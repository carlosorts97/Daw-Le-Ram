<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\Sizes;
use App\Form\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/user/articles", name="app_showArticles")
     */
    public function showArticles()
    {
        $id = $this->getUser();
        $sizes= new Sizes();
        $sizes = $this->getDoctrine()->getRepository(Sizes::class)->findBy(['user'=>$id]);
        $articles = $this->getDoctrine()->getRepository(Articles::class)->find($sizes->getArticle());
        return $this->render('admin/index.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/register",name="app_register")
     */
    public function register (Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user=new User();

        //create the form
        $form=$this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //encrypt password
            $user->setRoles(['ROLE_USER']);
            $password=$passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //handle the entities
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'User2 created'
            );
            return $this->redirectToRoute('app_homepage');
        }

        //render the form
        return $this->render('users/regform.html.twig',[
            'error'=>$error,
            'form'=>$form->createView()
        ]);

    }
    /**
     * @Route("/editAccount",name="app_editAccount")
     */
    public function editAccount (Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $id = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        //create the form
        $form=$this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //encrypt password
            $password=$passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //handle the entities
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }

        //render the form
        return $this->render('users/editinfo.html.twig',[
            'error'=>$error,
            'form'=>$form->createView()
        ]);

    }
    /**
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @Route("/login",name="app_login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils){
        $error=$authUtils->getLastAuthenticationError();
        $lastUsername=$authUtils->getLastUsername();
        return $this->render('user/login.html.twig', [
            'error'=>$error,
            'last_username'=>$lastUsername
        ]);
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){
        $this->redirectToRoute('app_homepage');
    }
}
