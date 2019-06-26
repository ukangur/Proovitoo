<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\NewArticleType;
use App\Repository\ArticleRepository;

class NewsController extends Controller{
    
    public function index(){
    
        $articles = $this->getDoctrine()->getRepository(Article::class)->findby([],['date' => 'DESC']);
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();


    return $this->render('newsarticles/index.html.twig', array('articles' => $articles,'categories' => $categories));
    }

    public function showArt($id) {
        
        $article = $this->getDoctrine()->getRepository
        (Article::class)->find($id);

        return $this->render('newsarticles/show.html.twig', array
        ('article' => $article));
    }

    public function showCat($id, ArticleRepository $query, Request $request) {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $queryBuilder = $this->getDoctrine()->getRepository(Article::class)->createFindAllQuery($category);

        $data = $this->get('knp_paginator')->paginate(
            $queryBuilder->getQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 10)/*limit per page*/
        );
        
            return $this->render('newsarticles/category.html.twig', array('category' => $category, 'data' => $data));
    }

    public function commentArt(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findby(array('Article' => $article));
        $comment = new Comment();
        $comment->setArticle($article);
        $comment->setDate(new \DateTime('now'));
        $form = $this->createFormBuilder($comment)
          ->add('author', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('body', TextareaType::class, array(
            'required' => true,
            'attr' => array('class' => 'form-control')
          ))
          ->add('save', SubmitType::class, array(
            'label' => 'Post comment',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $comment = $form->getData();
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($comment);
          $entityManager->flush();
          return $this->redirectToRoute('comments', array('id' => $id));
        }
        return $this->render('newsarticles/comments.html.twig', array(
          'form' => $form->createView(), 'article' => $article, 'comments' => $comments
        ));
      }

    
    public function deleteCommentArt(Request $request, $id, $cid): Response
    {
        $comment = $this->getDoctrine()->getRepository(Comment::class)->find($cid);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($comment);
        $entityManager->flush();
        
        return $this->redirectToRoute('comments', array('id' => $id));
    }
  
}