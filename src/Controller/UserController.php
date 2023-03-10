<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Follow;
use App\Entity\Activity;
use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user', name: 'profile')]
    public function profile(UserInterface $cuser): Response
    {
        $user = $this->getUser();
        $id=$cuser->getId();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $activity = $this->getDoctrine()->getRepository(Activity::class)->findBy(['too'=>$id]);
        $follwers = $this->getDoctrine()->getRepository(Follow::class)->findBy(['followed'=>$id]);
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(['owner'=>$id]);
        return $this->render('user/show.html.twig', [
            'user' => $user,'follwers'=>$follwers,'activity'=>$activity,'users'=>$users,'posts'=>$posts
        ]);
    }


    #[Route('/showitem', name: 'showitem')]
    public function showitem(UserInterface $cuser): Response
    {
        $user = $this->getUser();
        $id=$cuser->getId();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $activity = $this->getDoctrine()->getRepository(Activity::class)->findBy(['too'=>$id]);
        $follwers = $this->getDoctrine()->getRepository(Follow::class)->findBy(['followed'=>$id]);
        return $this->render('user/showitem.html.twig', [
            'user' => $user,'follwers'=>$follwers,'activity'=>$activity,'users'=>$users
        ]);
    }


    #[Route('/showcollection', name: 'showcollection')]
    public function showcollection(UserInterface $cuser): Response
    {
        $user = $this->getUser();
        $id=$cuser->getId();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $activity = $this->getDoctrine()->getRepository(Activity::class)->findBy(['too'=>$id]);
        $follwers = $this->getDoctrine()->getRepository(Follow::class)->findBy(['followed'=>$id]);
        return $this->render('user/collections.html.twig', [
            'user' => $user,'follwers'=>$follwers,'activity'=>$activity,'users'=>$users
        ]);
    }


    #[Route('/editprofile', name: 'editprofile')]
    public function editprofile(Request $request,EntityManagerInterface $manager): Response
    {
       
      
        $user =$this->getUser();
        $form =$this->createForm(EditProfilType::class,$user);
        $img = $form->get('image')->getData();
        $img2 = $form->get('cover')->getData();
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            if ($file = $form->get('image')->getData() ){
           
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
            } $user->setImage($fileName);
        
        
        }

            else {$user->setImage($img);}
            


           
           
            if ($file2 = $form->get('cover')->getData() ){
           
                $file2 = $form->get('cover')->getData();
                $fileName2 = md5(uniqid()).'.'.$file2->guessExtension();
    
                try {
                    $file2->move(
                        $this->getParameter('images_directory'),
                        $fileName2
                    );
                } catch (FileException $e) {
                } $user->setCover($fileName2);
            
            
            }else {$user->setCover($img2);}
                
               
            
           
           
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                "les données du profil ont éte enregister avec succés"
            );
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,'form'=>$form->createView(),
        ]);
    }

    #[Route('/user/show/{id}', name: 'show_user')]
    public function show($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userid=$this->getUser();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $activity = $this->getDoctrine()->getRepository(Activity::class)->findBy(['too'=>$id]);
        $isfollowed = $this->getDoctrine()->getRepository(Follow::class)->findOneBy(['user'=>$userid , 'followed'=> $id]);
        $follwers = $this->getDoctrine()->getRepository(Follow::class)->findBy(['followed'=>$id]);
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(['owner'=>$id]);

        return $this->render('user/show.html.twig', [
            'user' => $user,'follwers'=>$follwers,'isfollowed'=>$isfollowed,'activity'=>$activity,'users'=>$users,'posts'=>$posts
        ]);
    }
    

    #[Route('/user/follow/{id}', name: 'follow')]
    public function follow($id): Response
    {

        $follow = new Follow();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $follow->setFollowed($id);
        $follow->setUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($follow);
        $entityManager->flush();
        
        return $this->redirectToRoute('show_user',['id' => $user->getId()]);
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/unfollow/{id}', name: 'unfollow')]
    public function unfollow($id): Response
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userid=$this->getUser();
        $follow = $this->getDoctrine()->getRepository(Follow::class)->findOneBy(['user'=>$userid , 'followed'=> $id]);
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($follow);
        $entityManager->flush();
        
        return $this->redirectToRoute('show_user',['id' => $user->getId()]);
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/user/outfollow/{id}', name: 'outfollow')]
    public function outfollow($id): Response
    {

        $follow = new Follow();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $follow->setFollowed($id);
        $follow->setUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($follow);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_home');
        return $this->render('home/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/outunfollow/{id}', name: 'outunfollow')]
    public function outunfollow($id): Response
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userid=$this->getUser();
        $follow = $this->getDoctrine()->getRepository(Follow::class)->findOneBy(['user'=>$userid , 'followed'=> $id]);
        

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($follow);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_home');
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
