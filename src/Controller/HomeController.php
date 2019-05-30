<?php
/**
 * Created by PhpStorm.
 * User2: linux
 * Date: 23/01/19
 * Time: 17:54
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(){

        $em = $this->getDoctrine()->getEntityManager();
        $conn = $em->getConnection();
        /*-----------------------------------------CONSULTAS----------------------------------------------------*/
        /*STREETWEAR*/
        $sql = '
         SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE (category=1 OR category=2 OR category=3 OR category=5) AND price > 0
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY retail_date ASC
            LIMIT 3;
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $stHype= $stmt->fetchAll();
        $sql = '
        SELECT id_article, name,articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
            from articles
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE (category=1 OR category=2 OR category=3 OR category=5) AND price > 0
            GROUP BY id_article, articles.retail_date, articles.name,category,brand,image
            ORDER BY retail_date DESC
            LIMIT 3;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $stLast= $stmt->fetchAll();

        /*SNEAKERS*/
        $sql = '
        SELECT id_article, name, articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
        from articles
        LEFT JOIN sizes ON articles.id_article = sizes.article
        WHERE category=4 AND price > 0
        GROUP BY id_article,articles.retail_date, articles.name,category,brand,image
        ORDER BY retail_date DESC
        LIMIT 3
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $snkHype= $stmt->fetchAll();

        $sql = '
        SELECT id_article, name, articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
        from articles
        LEFT JOIN sizes ON articles.id_article = sizes.article
        WHERE category=4 AND price > 0
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