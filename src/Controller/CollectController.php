<?php

namespace App\Controller;

use App\Entity\Collect;
use App\Form\CollectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CollectController extends AbstractController
{
    #[Route('/collect', name: 'collections')]
    public function index(): Response
    {
        $collects = $this->getDoctrine()->getRepository(Collect::class)->findAll();
        return $this->render('collect/index.html.twig', [
            'collects' => $collects,
        ]);
    }

    #[Route('/collect/add', name: 'add_collect')]
    public function add(Request $request): Response
    {
        $collects = $this->getDoctrine()->getRepository(Collect::class)->findBy(['user'=>$this->getUser()]);
        $collect = new Collect();
        $form = $this->CreateForm(CollectType::class,$collect);
        $form->handlerequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $collect->setUser($this->getUser());
            $em->persist($collect);
            $em->flush();
            return $this->redirectToRoute('add_collect');
        }
        return $this->render('collect/add.html.twig', [
            'form' => $form->createView(),'collects'=>$collects
        ]);
    }


    #[Route('/collect/show/{id}', name: 'show_collect')]
    public function show($id): Response
    {
        $collects = $this->getDoctrine()->getRepository(Collect::class)->findOneById($id);
       
        return $this->render('collect/display.html.twig', [
            'collects'=>$collects
        ]);
    }
}
