<?php
/**
 * Created by PhpStorm.
 * User2: linux
 * Date: 23/01/19
 * Time: 17:54
 */

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

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
            SELECT id_article, name,articles.retail_date, articles.name,category,brand,count(id_sell) AS compras ,AVG(price) AS price,image
            FROM sells
            LEFT JOIN articles ON sells.article = articles.id_article
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE (category=1 OR category=2 OR category=3 OR category=5) AND price > 0
            group by id_article, name,articles.retail_date, articles.name,category,brand,image
            ORDER BY compras DESC
            LIMIT 3
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $stHype= $stmt->fetchAll();

        if($stHype == null)
        {
            $sql = '
        SELECT id_article, name, articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
        from articles
        LEFT JOIN sizes ON articles.id_article = sizes.article
        WHERE (category=1 OR category=2 OR category=3 OR category=5) AND price > 0
        GROUP BY id_article,articles.retail_date, articles.name,category,brand,image
        ORDER BY id_article DESC
        LIMIT 3
        ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $snkHype= $stmt->fetchAll();
        }


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
            SELECT id_article, name,articles.retail_date, articles.name,category,brand,count(id_sell) AS compras ,AVG(price) AS price,image
            FROM sells
            LEFT JOIN articles ON sells.article = articles.id_article
            LEFT JOIN sizes ON articles.id_article = sizes.article
            WHERE category=4 AND price > 0
            group by id_article, name,articles.retail_date, articles.name,category,brand,image
            ORDER BY compras DESC
            LIMIT 3
        ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $snkHype= $stmt->fetchAll();

        if($snkHype == null)
        {
            $sql = '
        SELECT id_article, name, articles.retail_date, articles.name,category,brand, AVG(sizes.price) AS price, image
        from articles
        LEFT JOIN sizes ON articles.id_article = sizes.article
        WHERE category=4 AND price > 0
        GROUP BY id_article,articles.retail_date, articles.name,category,brand,image
        ORDER BY id_article DESC
        LIMIT 3
        ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $snkHype= $stmt->fetchAll();
        }


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

    /**
     * @Route("/hola/category",name="app_categoryInsert")
     */
    public function InsertIntoCategory (){
        $category=new Category();
        $category->setName("Camisetas");
        $category2=new Category();
        $category2->setName("Sudaderas");
        $category3=new Category();
        $category3->setName("Pantalones");
        $category4=new Category();
        $category4->setName("Sneakers");
        $category5=new Category();
        $category5->setName("Accesorios");
        dump($category);
        dump($category2);
        dump($category3);
        dump($category4);
        dump($category5);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->persist($category2);
        $entityManager->persist($category3);
        $entityManager->persist($category4);
        $entityManager->persist($category5);
        $entityManager->flush();



        //render the form
        return $this->render('home/home.html.twig');

    }
    /**
     * @Route("/hola/brand",name="app_brandInsert")
     */
    public function InsertIntobrand (){
        $category=new Category();
        $category->setName("Supreme");
        $category2=new Category();
        $category2->setName("Palace");
        $category3=new Category();
        $category3->setName("Nike");
        $category4=new Category();
        $category4->setName("Adidas");
        $category5=new Category();
        $category5->setName("Off-White");
        $category6=new Category();
        $category6->setName("Heron preston");
        $category7=new Category();
        $category7->setName("Kith");
        $category8=new Category();
        $category8->setName("Kaws");
        $category9=new Category();
        $category9->setName("Yeezy");
        $category10=new Category();
        $category10->setName("Air jordan");
        $category11=new Category();
        $category11->setName("Stussy");
        $category12=new Category();
        $category12->setName("Bape");
        $category13=new Category();
        $category13->setName("Billionaire boys club");
        $category14=new Category();
        $category14->setName("Gucci");
        $category15=new Category();
        $category15->setName("Louis vuitton");

        dump($category);
        dump($category2);
        dump($category3);
        dump($category4);
        dump($category5);
        dump($category6);
        dump($category7);
        dump($category8);
        dump($category9);
        dump($category10);
        dump($category11);
        dump($category12);
        dump($category13);
        dump($category14);
        dump($category15);
        die();

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->persist($category2);
        $entityManager->persist($category3);
        $entityManager->persist($category4);
        $entityManager->persist($category5);
        $entityManager->flush();



        //render the form
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/hola/admin",name="app_adminInsert")
     */
    public function InsertIntoadmin (){
        $user_admin=new User();
        $user_admin->setName("Admin");
        $user_admin->setPassword("1234");
        $user_admin->setRoles(['ROLE_USER']);
        $user_admin->setAddress("Calle Admin");
        $user_admin->setEmail("admin@gmail.com");
        $user_admin->setBirthday(new \DateTime());
        $user_admin->setPlainPassword("1234");
        $user_admin->setUsername("admin");
        $user_admin->setCity($this->getDoctrine()->getRepository(Cities::class)->find("1"));

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($user_admin);

        $entityManager->flush();



        //render the form
        return $this->render('home/home.html.twig');

    }

    /**
     * @Route("/hola/pais",name="app_paisInsert")
     */
    public function InsertIntoPaises (){
        $pais=new Countries();
        $pais->setName("España");

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($pais);

        $entityManager->flush();



        //render the form
        return $this->render('home/home.html.twig');

    }

    /**
     * @Route("/hola/ciudad",name="app_ciudadInsert")
     */
    public function InsertIntoCiudades (){
        $ciudad=new Cities();
        $ciudad->setName("Cataluña");
        $ciudad->setCountry($this->getDoctrine()->getRepository(Countries::class)->find("1"));

        $ciudad2=new Cities();
        $ciudad2->setName("Madrid");
        $ciudad2->setCountry($this->getDoctrine()->getRepository(Countries::class)->find("1"));

        $ciudad3=new Cities();
        $ciudad3->setName("Galicia");
        $ciudad3->setCountry($this->getDoctrine()->getRepository(Countries::class)->find("1"));

        $ciudad4=new Cities();
        $ciudad4->setName("Valencia");
        $ciudad4->setCountry($this->getDoctrine()->getRepository(Countries::class)->find("1"));

        $ciudad5=new Cities();
        $ciudad5->setName("Andalucia");
        $ciudad5->setCountry($this->getDoctrine()->getRepository(Countries::class)->find("1"));

        $ciudad6=new Cities();
        $ciudad6->setName("País Vasco");
        $ciudad6->setCountry($this->getDoctrine()->getRepository(Countries::class)->find("1"));

        $ciudad7=new Cities();
        $ciudad7->setName("Extremadura");
        $ciudad7->setCountry($this->getDoctrine()->getRepository(Countries::class)->find("1"));

        $ciudad8=new Cities();
        $ciudad8->setName("Murcia");
        $ciudad8->setCountry($this->getDoctrine()->getRepository(Countries::class)->find("1"));

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($ciudad);
        $entityManager->persist($ciudad2);
        $entityManager->persist($ciudad3);
        $entityManager->persist($ciudad4);
        $entityManager->persist($ciudad5);
        $entityManager->persist($ciudad6);
        $entityManager->persist($ciudad7);
        $entityManager->persist($ciudad8);
        $entityManager->flush();



        //render the form
        return $this->render('home/home.html.twig');

    }
}