<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Follow;
use App\Entity\Collect;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {   $user = $this->getUser();
        $collects = $this->getDoctrine()->getRepository(Collect::class)->findAll();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        $follwers = $this->getDoctrine()->getRepository(Follow::class)->findAll();
        return $this->render('home/index.html.twig', [
            'posts' => $posts,'users'=>$users,'follwers'=>$follwers,'user' => $user,'collects' => $collects,
        ]);
    }
}
