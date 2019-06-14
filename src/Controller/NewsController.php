<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\NewArticleType;

class NewsController extends Controller{
    /**
     * @Route("/")
     * @Method({{"GET"}})
     */
    
    public function index(){
        //return new Response('<html><body>Hello</body></html>');
    
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();


    return $this->render('newsarticles/index.html.twig', array('articles' => $articles,'categories' => $categories));
    }

     /**
      * @Route("/article/new")
      */
     public function new(Request $request) {

        $article = new Article();

        $form = $this->createForm(NewArticleType::class, $article);
     

        return $this->render('newsarticles/new.html.twig', array(
            'forma' => $form->createView()));
     }

/*

     public function save() {
         
         $entityManager = $this->getDoctrine()->getManager();

         $category = new Category();
         $category->setTitle('category4');
         

         $entityManager->persist($category);

         $entityManager->flush();

         return new Response('Saved a category with the id of '. $category->getId());
     }
*/
     /*public function save() {
         $categories = ['category4','category2','category3'];
         $entityManager = $this->getDoctrine()->getManager();

         $article = new Article();
         $article->setTitle('Article Five');
         $article->setDescription('This is a short description of article five');
         $article->setBody('Body of article five');
         $article->setPicture('https://bobandsuewilliams.com/images/black-square-6.png');
         $article->setCategories($categories);
         $article->setDate(date("Y/m/d"));
         

         $entityManager->persist($article);

         $entityManager->flush();

         return new Response('Saved an article with the id of '. $article->getId());
     } */

     /**
     * @Route("/article/{id}")
     */

    public function show($id) {
        $article = $this->getDoctrine()->getRepository
        (Article::class)->find($id);

        return $this->render('newsarticles/show.html.twig', array
        ('article' => $article));
    }
}