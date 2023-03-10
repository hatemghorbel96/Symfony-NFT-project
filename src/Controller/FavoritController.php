<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoritController extends AbstractController
{
    #[Route('/like/{id}', name: 'up_like')]
    public function uplike(Post $post):Response {
       
    
        $post->addLike($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('posts');
         }
    
    
    #[Route('/dislike/{id}', name: 'down_like')]
    public function downlike(Post $post):Response {
       
    
        $post->removeLike($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('posts');
         }


         #[Route('/deeplike/{id}/{idu}', name: 'like')]
    public function like($id,$idu,Post $post):Response {
       
    
        $post->addLike($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('show_profil',[
            'id'=>$idu
        ]);
         }
    
    
    #[Route('/deepdislike/{id}/{idu}', name: 'dislike')]
    public function dislike($id,$idu,Post $post):Response {
       
        
        $post->removeLike($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('show_profil',[
            'id'=>$idu
        ]);
         }
}
