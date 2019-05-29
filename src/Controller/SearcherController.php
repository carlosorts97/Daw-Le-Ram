<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 29/05/19
 * Time: 16:46
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use App\Entity\Articles;
use App\Entity\Countries;
use App\Entity\Sizes;
use App\Form\EditUserType;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class SearcherController extends AbstractController
{
    /**
     * @Route("/search", name="adjkjkf")
     */
    public function index()
    {
        return $this->render('search/searcher.html.twig');
    }
    public function searchBar()
    {
        $form = $this->createFormBuilder(null)
            ->setAction($this->generateUrl('handle_search'))
            ->add("query", TextType::class, [
                'attr' => [
                    'placeholder'   => 'Enter search query...'
                ]
            ])
            ->add("submit", SubmitType::class)
            ->getForm()
        ;
        return $this->render('prueba/searcher.html.twig', [
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
     * @Route("/arti/{id?}", name="article_page", methods={"GET"})
     */
    public function citySingle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $city = null;

        if ($id) {
            $city = $em->getRepository(Articles::class)->findOneBy(['id' => $id]);
        }
        return $this->render('prueba/article.html.twig', [
            'city'  =>      $city
        ]);
    }
}