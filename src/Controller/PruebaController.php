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
     * @Route("/article/list/{category}/{brand}", name="prueba")
     */
    public function listArticles($category, $brand)
    {
        $filter = null;
        $title = null;

        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        if ($brand == 0) {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . '
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
        }
        /*Este elseif para cargar los articulos de categorias>resto de marcas*/
        elseif ($brand==66){
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
            $title="Resto de marcas";
        }
        /*Este elseif para cargar los articulos de categorias>resto de marcas*/
        elseif ($brand==99){
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND (brand<>3 AND brand<>4 AND brand<>5 AND brand<>9 AND brand<>10)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
            $title = "Resto de marcas";
        }
        else {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            From articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND brand='.$brand.'
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN= $this->getDoctrine()->getRepository(Brands::class)->find($brand);
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $articles= $stmt->fetchAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'category' => $category,
            'brand' => $brand,
            'brandN' => $brandN,
            'filter' => $filter,
            'title' => $title
        ]);
    }

    /**
     * @Route("/article/list/{category}/{brand}/cheap", name="app_articleslist_cheap")
     */
    public function listArticleFilterCheap($category, $brand)
    {
        $filter="Más barato a más caro";
        $title = null;

        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        if ($brand == 0) {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . '
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY price
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
        }
        /*Este elseif para cargar los articulos de categorias>resto de marcas*/
        elseif ($brand==66){
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY price
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
            $title = "Resto de marcas";
        }
        /*Este elseif para cargar los articulos de categorias>resto de marcas*/
        elseif ($brand==99){
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND (brand<>3 AND brand<>4 AND brand<>5 AND brand<>9 AND brand<>10)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY price
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
            $title = "Resto de marcas";
        }
        else {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            From articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND brand='.$brand.'
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY price
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN= $this->getDoctrine()->getRepository(Brands::class)->find($brand);
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $articles= $stmt->fetchAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'category' => $category,
            'brand' => $brand,
            'brandN' => $brandN,
            'filter' => $filter,
            'title' => $title
        ]);
    }

    /**
     * @Route("/article/list/{category}/{brand}/expensive", name="app_articleslist_expensive")
     */
    public function listArticleFilterExpensive($category, $brand)
    {
        $filter="Más caro a más barato";
        $title = null;
        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        if ($brand == 0) {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . '
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY price DESC
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
        }
        /*Este elseif para cargar los articulos de categorias>resto de marcas*/
        elseif ($brand==66){
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY price DESC
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
            $title = "Resto de marcas";
        }
        /*Este elseif para cargar los articulos de categorias>resto de marcas*/
        elseif ($brand==99){
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND (brand<>3 AND brand<>4 AND brand<>5 AND brand<>9 AND brand<>10)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY price DESC
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
            $title = "Resto de marcas";
        }
        else {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            From articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND brand='.$brand.'
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY price DESC
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN= $this->getDoctrine()->getRepository(Brands::class)->find($brand);
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $articles= $stmt->fetchAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'category' => $category,
            'brand' => $brand,
            'brandN' => $brandN,
            'filter' => $filter,
            'title' => $title
        ]);
    }

    /**
     * @Route("/article/list/{category}/{brand}/date", name="app_articleslist_date")
     */
    public function listArticleFilterRetailDate($category, $brand)
    {
        $filter="Más caro a más barato";
        $title = null;
        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        if ($brand == 0) {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . '
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY retail_date DESC
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
        }
        /*Este elseif para cargar los articulos de categorias>resto de marcas*/
        elseif ($brand==66){
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY retail_date DESC
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
            $title = "Resto de marcas";
        }
        /*Este elseif para cargar los articulos de categorias>resto de marcas*/
        elseif ($brand==99){
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND (brand<>3 AND brand<>4 AND brand<>5 AND brand<>9 AND brand<>10)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY retail_date DESC
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN=null;
            $title = "Resto de marcas";
        }
        else {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            From articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND brand='.$brand.'
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY retail_date DESC
            ';
            $category = $this->getDoctrine()->getRepository(Category::class)->find($category);
            $brandN= $this->getDoctrine()->getRepository(Brands::class)->find($brand);
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $articles= $stmt->fetchAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'category' => $category,
            'brand' => $brand,
            'brandN' => $brandN,
            'filter' => $filter,
            'title' => $title
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


        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        /*-----------------------------------------CONSULTAS----------------------------------------------------*/
        /*STREETWEAR*/
        $sql = '
        SELECT id_article, name, articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
        from articles
        INNER JOIN sizes ON articles.id_article = sizes.article
        WHERE category=1 OR category=2 OR category=3 OR category=5  
        GROUP BY id_article,articles.retail_date, articles.name,category,brand,image
        ORDER BY articles.retail_date DESC
        LIMIT 3
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $stHype= $stmt->fetchAll();

        $sql = '
        SELECT id_article, name, articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
        from articles
        INNER JOIN sizes ON articles.id_article = sizes.article
        WHERE category=1 OR category=2 OR category=3 OR category=5 
        GROUP BY id_article,articles.retail_date, articles.name,category,brand,image
        ORDER BY articles.retail_date DESC
        LIMIT 3
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $stLast= $stmt->fetchAll();

        /*SNEAKERS*/
        $sql = '
        SELECT id_article, name, articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
        from articles
        INNER JOIN sizes ON articles.id_article = sizes.article
        WHERE category=4  
        GROUP BY id_article,articles.retail_date, articles.name,category,brand,image
        ORDER BY articles.retail_date DESC
        LIMIT 3
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $snkHype= $stmt->fetchAll();

        $sql = '
        SELECT id_article, name, articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
        from articles
        INNER JOIN sizes ON articles.id_article = sizes.article
        WHERE category=4
        GROUP BY id_article,articles.retail_date, articles.name,category,brand,image
        ORDER BY articles.retail_date DESC
        LIMIT 3
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $snkLast= $stmt->fetchAll();
        /*-----------------------------------------CONSULTAS----------------------------------------------------*/


        return $this->render('home/home.html.twig', [
            'stHype' => $stHype,
            'stLast' => $stLast,
            'snkHype' => $snkHype,
            'snkLast' => $snkLast
        ]);
    }
}
