<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\Sizes;
use App\Entity\Stock;
use App\Entity\Brands;
use App\Form\NewArticleType;
use App\Entity\Articles;
use App\Entity\User;
use App\Form\NewSizeType;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PruebaController extends AbstractController
{
    /**
     * @Route("/prueba/{category}/{brand}", name="prueba")
     */
    public function index($category, $brand)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        if ($brand == 0) {
            $sql = '
            SELECT name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . '
            GROUP BY articles.retail_date, articles.name,category,brand
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brand=null;
        }
        else{
            $sql = '
            SELECT name,articles.retail_date,articles.name,category,brand, AVG(sizes.price) AS price 
            From articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND brand='.$brand.'
            GROUP BY articles.retail_date, articles.name,category,brand
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brand = $this->getDoctrine()->getRepository(Brands::class)->find($brand);
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $articles= $stmt->fetchAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'category' => $category,
            'brand' => $brand,
        ]);
    }

    /**
     * @Route("/prueba", name="prueba_home")
     */
    public function index_home()
    {
        $streetWear_hyped = $this->getDoctrine()->getRepository(Articles::class)->findBy(array('category'=>['1','2','3','5']),array('idArticle'=>'DESC'),3);
        $streetWear_last = $this->getDoctrine()->getRepository(Articles::class)->findBy(array('category'=>['1','2','3','5']),array('retailDate'=>'DESC'),3);
        $sneakers_hyped = $this->getDoctrine()->getRepository(Articles::class)->findBy(array('category'=>['4']),array('idArticle'=>'DESC'),3);
        $sneakers_last = $this->getDoctrine()->getRepository(Articles::class)->findBy(array('category'=>['4']),array('retailDate'=>'DESC'),3);
        $tallas = $this->getDoctrine()->getRepository(Sizes::class)->findBy(array('article'=>2));
        dump($tallas);
        die();
        $category = 2;

        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        $sql = '
        SELECT name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) from articles
        LEFT JOIN sizes ON articles.id_article = sizes.article
        WHERE category='.$category.'
        GROUP BY articles.retail_date, articles.name,category,brand
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $articles= $stmt->fetchAll();
        dump($articles);
        die();

        return $this->render('home/home.html.twig', [
            'streetWear_hyped' => $streetWear_hyped,
            'streetWear_last' => $streetWear_last,
            'sneakers_hyped' => $sneakers_hyped,
            'sneakers_last' => $sneakers_last
        ]);
    }
}
