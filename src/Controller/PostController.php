<?php

namespace App\Controller;

use App\Entity\Bet;
use App\Entity\Post;
use App\Entity\User;
use App\Form\BetType;
use App\Form\PostType;
use App\Entity\Activity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PostController extends AbstractController
{

    #[Route('/post', name: 'posts')]
    public function index(): Response
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/thanks', name: 'thanks')]
    public function thanks(): Response
    {
       
        return $this->render('bet/index.html.twig');
    }

    #[Route('/post/add', name: 'add_post')]
    public function add(Request $request): Response
    {
        $date = new \DateTime();
        $post = new Post();
        $form = $this->createForm(PostType::class,$post,['user'=>$this->getUser()]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post->setUser($this->getuser());
           
            $file = $form->get('img')->getData();
            
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) { }
            $post->setUser($this->getUser());
            $post->setCreatedAt($date);
           
            $post->setImg($fileName);
            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/post/show/{id}', name: 'post_show')]
    public function show($id,Request $request): Response
    {
        /* $winer = $this->getDoctrine()->getRepository(Bet::class)->winersearch($id); */
        $date = new \DateTime();
        $post = $this->getDoctrine()->getRepository(Post::class)->findOneById($id);
        $v=$post->getView();
        $v+=1;
        $post->setView($v);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $winer = $this->getDoctrine()->getRepository(Bet::class)->winersearch($id);
       /*  $winer = $this->getDoctrine()->getRepository(Bet::class)->bentent($id); */
       /*  $winerR = $this->getDoctrine()->getRepository(User::class)->test($id);
        $f=$winerR->getUserid(); */
        $bet = new Bet();
        $bets = $this->getDoctrine()->getRepository(Bet::class)->findBy(['post'=>$id]);
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id); 
       $form = $this->createForm(BetType::class,$bet);
       $form->handlerequest($request);
       if ($form->isSubmitted() && $form->isValid()){
         
           $bet->setUser($this->getUser())->setPost($post);
           if ($post->getPrice())
           {
               $data = $form->getData()->getDevis();
           if ($data < $post->getPrice()  )
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
                   'success',"c est bon"
               );                      
           } 

           }else{               
           $data = $form->getData()->getDevis();
           if ($data <= $post->getMinbet()  )
           {
               $this->addFlash(
                   'warning',"bet as8ar mel min"
               );
           }
           else
           {    
            $activity = new Activity();  
                $activity->setType('bets')  ;  
                $activity->setPrice($data);  
                $activity->setCreatedAt($date);      
                $activity->setFromm($post->getUser()->getId())  ;  
                $activity->setToo($this->getUser()->getId());  
                $activity->setPost($post);  
                 
                      
               $post->setMinbet($data);

               $em->persist($bet);
               
               $em->persist($post);
               $em->persist($activity);  
              
               
               $em->flush();
               $this->addFlash(
                   'sucess',"c est bon"
               );                      
           }                              
       }}
        return $this->render('post/show.html.twig', [
            'form' => $form->createView(),'post'=>$post,'bet'=>$bet,'bets'=>$bets,  'winer'=>$winer  /* ,'f'=>$f */
        ]);
    }


    #[Route('/post/buy/{id}', name: 'buy_post')]
    public function buy($id): Response
    {
        $date = new \DateTime();
        $post = $this->getDoctrine()->getRepository(Post::class)->findOneById($id);
       
      
       
            $activity = new Activity();  
                $activity->setType('sales')  ;  
                $activity->setPrice($post->getPrice());       
                $activity->setFromm($post->getUser()->getId())  ;  
                $activity->setToo($this->getUser()->getId());  
                $activity->setPost($post);  
                 
                      
              $em = $this->getdoctrine()->getManager();

               $post->setTypebuy(1);
               $post->setOwner($this->getUser());
               $post->setDateown($date);
               $em->persist($post);
               $em->persist($activity);  
              
               
               $em->flush();
                 
               return $this->redirectToRoute('thanks');
                                        
     
        return $this->render('post/show.html.twig', [
            'post'=>$post,
        ]);
    }

    public function endbet($id): Response
    {
          
        $date = new \DateTime();
        $post = $this->getDoctrine()->getRepository(Post::class)->findOneById($id);
        $winer = $this->getDoctrine()->getRepository(Bet::class)->bentent($id);
        $winerob = $this->getDoctrine()->getRepository(User::class)->returnob($id);
        /* $winer = $this->getDoctrine()->getRepository(User::class)->test($id); */
       /*  $f=$winer->getUserid(); */
       /* $f = $winerob->getUser(); */
        $activity = new Activity();  
        $activity->setType('won bet')  ;  
        $activity->setPrice($post->getMinbet());       
        $activity->setFromm($post->getUser()->getId());  
        $activity->setToo($winer);  
        $activity->setPost($post);  
         
              
      $em = $this->getdoctrine()->getManager();

       $post->setTypebuy(2);
       $post->setOwner($winerob);
       $post->setDateown($date);
       $em->persist($post);
       $em->persist($activity);  
      
       
       $em->flush();

        
        return $this->render('home/render.html.twig');
    }
}
