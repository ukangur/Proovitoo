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
     * @Route("/", name="home")
     * @Method({{"GET"}})
     */
    
    public function index(){
        //return new Response('<html><body>Hello</body></html>');
    
        $articles = $this->getDoctrine()->getRepository(Article::class)->findby([],['date' => 'DESC']);
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();


    return $this->render('newsarticles/index.html.twig', array('articles' => $articles,'categories' => $categories));
    }

     /**
      * @Route("/article/new", name="newarticle")
      */
     public function new(Request $request) {

        $article = new Article();

        $form = $this->createForm(NewArticleType::class, $article);
     

        return $this->render('newsarticles/new.html.twig', array(
            'formart' => $form->createView()));
     }

     /**
     * @Route("/article/{id}", name="show")
     */

    public function showArt($id) {
        $article = $this->getDoctrine()->getRepository
        (Article::class)->find($id);

        return $this->render('newsarticles/show.html.twig', array
        ('article' => $article));
    }

    /**
     * @Route("/category/{id}", name="categorylist")
     */

    public function showCat($id) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $articles = $this->getDoctrine()->getRepository(Article::class)->findby([],['date' => 'DESC']);

        return $this->render('newsarticles/category.html.twig', 
        ['category' => $category,
        'articles' => $articles]);
    }
}