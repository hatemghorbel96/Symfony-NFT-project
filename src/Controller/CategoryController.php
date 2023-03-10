<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'categories')]
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->render('category/index.html.twig', [
            'posts' => $posts,'categories'=>$categories
        ]);
    }

    #[Route('/category/add', name: 'add_category')]
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->CreateForm(CategoryType::class,$category);
        $form->handlerequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
           
            $em->persist($category);
            $em->flush();
        }
        return $this->render('category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/category/show/{id}', name: 'show_categorie')]
    public function show($id): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(['category'=>$id]);
        return $this->render('category/categories.html.twig', [
            'posts' => $posts,'categories'=>$categories
        ]);
    }

}
