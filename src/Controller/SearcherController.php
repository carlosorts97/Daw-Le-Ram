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

<<<<<<< HEAD
=======
use PhpParser\Node\Stmt\Catch_;
>>>>>>> 0ea765e0e07b935b7d383fbba73eaa7aec564837
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
<<<<<<< HEAD
        $countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

        return $this->render('search/searcher.html.twig', ['articles'=>$articles]);
=======
        return $this->render('users/search.html.twig', ['articles'=>$articles]);
>>>>>>> 0ea765e0e07b935b7d383fbba73eaa7aec564837
    }
    /**
     *
     * @Route("/searchingada", name="posearch")
     */
    public function searchAsssssssction(Request $request)
    {

<<<<<<< HEAD
        $username=$request->query->get('myCountry');
        $articles=$this->getDoctrine()->getRepository(Articles::class)->findOneBy(array('name'=>$username));
        $id=$articles->getIdArticle();
        $category=$articles->getCategory()->getIdCategory();
        
        return $this->redirectToRoute('app_homepage');
=======
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
>>>>>>> 0ea765e0e07b935b7d383fbba73eaa7aec564837
    }

}