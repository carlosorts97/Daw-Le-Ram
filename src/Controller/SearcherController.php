<?php
/**
 * Created by PhpStorm.
 * User: linux
<<<<<<< HEAD
 * Date: 29/05/19
 * Time: 16:46
=======
 * Date: 30/05/19
 * Time: 17:29
>>>>>>> 0ea765e0e07b935b7d383fbba73eaa7aec564837
 */

namespace App\Controller;

use PhpParser\Node\Stmt\Catch_;
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
use App\Controller\PruebaController;

class SearcherController extends Controller
{
    /**
     * Creates a new ActionItem entity.
     *
     * @Route("/search", name="ajax_search")
     */
    public function searchAction(Request $request)
    {
        $i=0;
        $articles=$this->getDoctrine()->getRepository(Articles::class)->findAll();
        foreach ($articles as $a){
            $articulos[$i]=$a->getName();
            $i=$i+1;
        }

        return $this->render('search/searcher.html.twig', ['articles'=>$articles]);
    }
    /**
     *
     * @Route("/searchingada", name="posearch")
     */
    public function searchAsssssssction(Request $request)
    {

        $username=$request->query->get('buscador');
        $articles=$this->getDoctrine()->getRepository(Articles::class)->findOneBy(array('name'=>$username));
        if($articles != null){
            $id=$articles->getIdArticle();
            $category=$articles->getCategory()->getIdCategory();

            return $this->redirect($this->generateUrl('app_showArticle', array('id' => $id,'category'=>$category)));
        }

        return $this->redirect($this->generateUrl('app_listArticles', array('category'=>1,'brand'=>0)));

    }

    public function searchBar(Request $request)
    {

        return $this->render('search/searcher.html.twig');

    }

}