<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\CreditCard;
use App\Entity\Sells;
use App\Entity\Sizes;
use App\Form\CardType;
use App\Form\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

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
        $sizes = $this->getDoctrine()->getRepository(Sizes::class)->findBy(['user'=>$id]);
        $articles = $this->getDoctrine()->getRepository(Articles::class)->findBy(['idArticle'=>$sizes]);
        return $this->render('user/showArticles.html.twig', [
            'sizes' => $sizes
        ]);
    }
    /**
     * @Route("/user/articles/{id}/{category}", name="app_showArticle")
     */
    public function showArticle($id)
    {
        $idUser = $this->getUser();

        $sizes = $this->getDoctrine()->getRepository(Sizes::class)->findOneBy(['article'=>$id, 'user'=>$idUser]);

        $articles = $this->getDoctrine()->getRepository(Articles::class)->find($sizes->getArticle());



        return $this->render('user/showArticles.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/user/orders", name="app_showOrders")
     */
    public function showOrders()
    {
        $id = $this->getUser();

        $order = $this->getDoctrine()->getRepository(Sells::class)->findBy(['buyer'=>$id]);
        return $this->render('user/ShowOrders.html.twig', [
            'orders' => $order
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
        $articles=$this->getDoctrine()->getRepository(Articles::class)->findAll();
        $error=$authUtils->getLastAuthenticationError();
        $lastUsername=$authUtils->getLastUsername();
        return $this->render('user/login.html.twig', [
            'error'=>$error,
            'last_username'=>$lastUsername,
            'articles'=>$articles
        ]);
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(){
        $this->redirectToRoute('app_homepage');
    }

    /**
     * @Route("/search", name ="app_search")
     */
    public function search(){

        $form = $this->createForm(SearchType::class);
        return $this->render('search/searcher.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/handleSearch/{_query?}", name="handle_search", methods={"POST", "GET"})
     */
    public function handleSearchRequest(Request $request, $_query)
    {
        $em = $this->getDoctrine()->getManager();
        if ($_query)
        {
            $data = $em->getRepository(Articles::class)->findBy($_query);
        } else {
            $data = $em->getRepository(Articles::class)->findAll();
        }
        // iterate over all the resuls and 'inject' the image inside
        for ($index = 0; $index < count($data); $index++)
        {
            $object = $data[$index];
            // http://via.placeholder.com/35/0000FF/ffffff
        }
        // setting up the serializer
        $normalizers = [
            new ObjectNormalizer()
        ];
        $encoders =  [
            new JsonEncoder()
        ];
        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->serialize($data, 'json');
        return new JsonResponse($data, 200, [], true);
    }
    /**
     * @Route("/user/card",name="app_addCard")
     */
    public function addCard (Request $request){
        $card=new CreditCard();

        //create the form
        $form=$this->createForm(CardType::class,$card);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){

            $card->setUser($this->getUser());
            //handle the entities
            dump($card);
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($card);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'User2 created'
            );
            return $this->redirectToRoute('app_homepage');
        }

        //render the form
        return $this->render('user/cardform.html.twig',[
            'error'=>$error,
            'form'=>$form->createView()
        ]);

    }
}
