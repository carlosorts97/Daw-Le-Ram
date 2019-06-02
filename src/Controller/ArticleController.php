<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Entity\CreditCard;
use App\Entity\Sizes;
use App\Entity\Stock;
use App\Entity\Sells;
use App\Entity\Brands;
use App\Form\CardType;
use App\Form\NewArticleType;
use App\Entity\Articles;
use App\Entity\User;
use App\Form\NewSizeType;
use App\Form\NewSneakerType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/article/{id}", name="app_LoadArticle")
     */
    public function loadArticle($id)
    {

        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
        return $this->render('article/article.html.twig', array(
            'article' => $article,
        ));
    }



    /**
     * @Route("/upArticle/{id}", name="app_uploadSizes")
     */
    public function uploadA3rticle(Request $Request, $id)
    {

        $size = new Sizes();
        $idUser= $this->getUser();
        $stockUpdate = null;

        $a=$this->getDoctrine()->getRepository(Articles::class)->find($id);

        if($a->getCategory()->getIdCategory()!=4) {
            $form = $this->createForm(NewSizeType::class, $size);
        }else{
            $form = $this->createForm(NewSneakerType::class, $size);
        }
        //handle the request
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {

            $size->setArticle($a);

            $size->setUser($idUser);

            $stock= $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
                'size' => $size->getSize(),
                'article' => $this->getDoctrine()->getRepository(Articles::class)->find($id),
            ]);

            if($stock == null){
                $stock = new Stock();
                $stock->AddStock();
                $size->setStock($stock);
            }else{
                $stockUpdate= $stock->getStock();

                $stockUpdate->AddStock();

                $size->setStock($stockUpdate);
            }

            $size = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($size);
            if($stockUpdate == null){
                $entityManager->persist($stock);
            }else{
                $entityManager->persist($stockUpdate);
            }
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }
        //render the form
        return $this->render('article/upProduct.html.twig', [
            
             'art'=>$a, 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editUploadedArticle/{id}/{size}", name="app_editUpArt")
     */
    public function editArticle(Request $Request, $id, $size)
    {

        $idUser = $this->getUser();
        $article = $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
            'article' => $id,
            'user' =>$idUser,
            'size' => $size
        ]);
        $a=$this->getDoctrine()->getRepository(Articles::class)->find($id);
        //crear form
        if($a->getCategory()->getIdCategory()!=4) {
            $form = $this->createForm(NewSizeType::class, $article);
        }else{
            $form = $this->createForm(NewSneakerType::class, $article);
        }
        //handle the request
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setArticle($this->getDoctrine()->getRepository(Articles::class)->find($id));
            $article->setUser($idUser);

            $stock = $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
                'size' => $article->getSize(),
                'article' => $this->getDoctrine()->getRepository(Articles::class)->find($id),
            ]);

            $stockUpdate = $stock->getStock();

            $stockUpdate->AddStock();

            $article->setStock($stockUpdate);



            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }
        //render the form
        return $this->render('article/upProduct.html.twig', [
            'form' => $form->createView(), 'art'=>$a
        ]);
    }

    /**
     * @Route("article/{id}/{size}/delete", name="app_articleSize_delete")
     */
    public function deleteArticle($id, $size)
    {
        $em = $this->getDoctrine()->getManager();
        $idUser=$this->getUser();
        $article = $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
            'article' => $id,
            'user' =>$idUser,
            'size' =>$size

        ]);
        $article->getStock()->RemoveStock();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('app_homepage');


    }


    /**
     * @Route("/loadSearcher", name="loadSearch")
     */
    public function searchear()
    {

        $articles=$this->getDoctrine()->getRepository(Articles::class)->findAll();

        return $this->render('article/searcherUpProduct.html.twig', ['articles'=>$articles]);
    }


    /**
     * @Route("/article/checkout/{id}/{size}/{seller}", name="app_checkout")
     */
    public function editAccount (Request $request, $id, $size, $seller){
        $idUser = $this->getUser();
        if(empty($idUser)){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);

        $card= new CreditCard();
        $form=$this->createForm(CardType::class, $card);

        $cards=$user->getCard();

        $article=$this->getDoctrine()->getRepository(Articles::class)->find($id);
        $size = $this->getDoctrine()->getRepository(Sizes::class)->findOneBy([
            'article' => $id,
            'user' =>$seller,
            'size' =>$size

        ]);


        if(empty($cards[0])!=false){

            $form=$this->createForm(CardType::class, $cards[0]);
        }
        $form1=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $form1->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            /*Removing stock*/
            $size->getStock()->RemoveStock();

            /*catching info for sell type*/
            $seller= $this->getDoctrine()->getRepository(User::class)->find($seller);
            $buyer= $this->getDoctrine()->getRepository(User::class)->find($idUser);
            //Create sells
            $sell=new Sells();
            $fileName = $this->generateUniqueFileName();
            $sell->setIdSell($fileName);
            /*puting info on sell*/
            $sell->setSeller($seller);
            $sell->setBuyer($buyer);
            $sell->setSize($size->getSize());
            $sell->addArticle($this->getDoctrine()->getRepository(Articles::class)->find($id));
            $sell->setTotalPaid($size->getPrice()+10);
            dump($sell);
            /*adding new info of user, removing size and creating sell*/
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->remove($size);
            $entityManager->persist($sell);
            $entityManager->persist($user);
            $entityManager->persist($card);
            $entityManager->flush();
            return $this->redirectToRoute('article/successfulBought.html.twig');
        }

        //render the form
        return $this->render('article/buyArticle.html.twig',[
            'error'=>$error,
            'form'=>$form->createView(),
            'formU'=>$form1->createView(),
            'size' =>$size
        ]);

    }
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

}
