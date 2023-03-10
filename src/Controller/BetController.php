<?php

namespace App\Controller;

use App\Entity\Bet;
use App\Entity\Post;
use App\Form\BetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BetController extends AbstractController
{
    #[Route('/bet', name: 'add_bet')]
    public function add(/* Ad $ad, */$id ,Request $request,EntityManagerInterface $em): Response
        {
            $bet = new Bet();
             $post = $this->getDoctrine()->getRepository(Post::class)->find($id); 
            $form = $this->createForm(BetType::class,$bet);
            $form->handlerequest($request);
            if ($form->isSubmitted() && $form->isValid()){
              
                $bet->setUser($this->getUser())->setPost($post);
                if ($post->getPrice())
                {
                    $data = $form->getData()->getDevis();
                    $ndata = $data * 100;
                if ($ndata > $post->getPrice() )
                {
                    $this->addFlash(
                        'warning',"ma tejemch "
                    );
                }
                else
                {                    
                    $post->setPrice($data);
                    $em->persist($bet);
                    $em->persist($post);
                    $em->flush();
                    $this->addFlash(
                        'sucess',"c est bon"
                    );                      
                } 

                }else{  
                    $form2 = $this->createForm(BetType::class,$bet);             
                $data = $form2->getData()->getDevis();
                $ndata = $data * 100;
                if ($ndata > $post->getMinbet()  )
                {
                    $this->addFlash(
                        'warning',"ma tejemch "
                    );
                }
                else
                {                   
                    $post->setMinbet($data);
                    $em->persist($bet);
                    $em->persist($post);
                    $em->flush();
                    $this->addFlash(
                        'sucess',"c est bon"
                    );                      
                }                              
            }
            return $this->redirectToRoute('post_show',['id'=>$id]);
        }
            return $this->render('bet/index.html.twig', [
                'form' => $form->createView(),'post'=>$post,'bet'=>$bet,'form' => $form->createView()
            ]);
        }
}
