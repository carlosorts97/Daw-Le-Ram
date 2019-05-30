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
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PruebaController extends AbstractController
{
    /**
     * @Route("/article/list/{category}/{brand}", name="app_listArticles")
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
            WHERE category=' . $category . ' AND price > 0
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
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14) AND price > 0
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
            WHERE category=' . $category . ' AND (brand<>3 AND brand<>4 AND brand<>5 AND brand<>9 AND brand<>10) AND price > 0
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
            WHERE category=' . $category . ' AND brand='.$brand.' AND price > 0
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
            WHERE category=' . $category . ' AND price > 0
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
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14) AND price > 0
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
            WHERE category=' . $category . ' AND (brand<>3 AND brand<>4 AND brand<>5 AND brand<>9 AND brand<>10) AND price > 0
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
            WHERE category=' . $category . ' AND brand='.$brand.' AND price > 0
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
            WHERE category=' . $category . ' AND price > 0
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
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14) AND price > 0
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
            LEFT JOIN sizes ON articles.id_article = sizes.article AND price > 0
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
            WHERE category=' . $category . ' AND brand='.$brand.' AND price > 0
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
        $filter="Más nuevos";
        $title = null;
        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        if ($brand == 0) {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND price > 0
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
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14) AND price > 0
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
            WHERE category=' . $category . ' AND (brand<>3 AND brand<>4 AND brand<>5 AND brand<>9 AND brand<>10) AND price > 0
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
            WHERE category=' . $category . ' AND brand='.$brand.' AND price > 0
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
     * @Route("/article/list/{category}/{brand}/name", name="app_articleslist_name")
     */
    public function listArticleFilterName($category, $brand)
    {
        $filter="Orden alfabético";
        $title = null;

        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        if ($brand == 0) {
            $sql = '
            SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=' . $category . ' AND price > 0
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY name ASC
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
            WHERE category=' . $category . ' AND (brand<>1 AND brand<>5 AND brand<>14) AND price > 0
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY name ASC
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
            LEFT JOIN sizes ON articles.id_article = sizes.article AND price > 0
            WHERE category=' . $category . ' AND (brand<>3 AND brand<>4 AND brand<>5 AND brand<>9 AND brand<>10)
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY name ASC
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
            WHERE category=' . $category . ' AND brand='.$brand.' AND price > 0
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY name ASC
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
     * @Route("/article/show/{id}/{category}", name="app_showArticle")
     */
    public function show_article($id, $category)
    {

        $article = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);

        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();

        $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category = '.$category.' AND price > 0
            GROUP BY articles.id_article, articles.name,articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 3
            ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $recommended= $stmt->fetchAll();

        if($category == 4)
        {
            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="36" AND price > 0
            GROUP BY articles.id_article, articles.name,articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_36= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="37" AND price > 0
            GROUP BY articles.id_article, articles.name,articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_37= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="38" AND price > 0
            GROUP BY articles.id_article, articles.name,articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_38= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="39" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_39= $stmt->fetchAll();

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_38= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="39" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_39= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="40" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_40= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="41" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_41= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="42" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_42= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="43" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_43= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id. ' AND size="44" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_44= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="45" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_45= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="46" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_46= $stmt->fetchAll();

            return $this->render('article/article_sneaker.html.twig', [
                'article_36' => $article_36,
                'article_37' => $article_37,
                'article_38' => $article_38,
                'article_39' => $article_39,
                'article_40' => $article_40,
                'article_41' => $article_41,
                'article_42' => $article_42,
                'article_43' => $article_43,
                'article_44' => $article_44,
                'article_45' => $article_45,
                'article_46' => $article_46,
                'recommended'=> $recommended,
                'article' => $article
            ]);

        }
        else{
            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="S" AND price > 0
            GROUP BY articles.id_article, articles.name,articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_S= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="M" AND price > 0
            GROUP BY articles.id_article, articles.name,articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_M= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="L" AND price > 0
            GROUP BY articles.id_article, articles.name,articles.description, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_L= $stmt->fetchAll();

            $sql = '
            SELECT articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE article=' . $id . ' AND size="XL" AND price > 0
            GROUP BY articles.id_article, articles.name, articles.retail_date, articles.name, 
            articles.category,articles.brand, articles.image,sizes.price,sizes.user,sizes.size,sizes.stock
            ORDER BY price ASC
            LIMIT 1
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $article_XL= $stmt->fetchAll();
        }

        return $this->render('article/article.html.twig', [
            'article_S' => $article_S,
            'article_M' => $article_M,
            'article_L' => $article_L,
            'article_XL' => $article_XL,
            'recommended' => $recommended,
            'article' => $article
        ]);
    }
}
