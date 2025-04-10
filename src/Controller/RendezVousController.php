<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RendezVousController extends AbstractController
{
    #[Route('/rendez_vous/add', name: 'add_rendez_vous', methods: ['GET', 'POST'])]
    public function add(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $rendezVous=new RendezVous();
        $form=$this->createForm(RendezVousType::class,$rendezVous);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($rendezVous);
            $entityManagerInterface->flush();
            $this->addFlash('success','Rendez-vous ajouté avec succès');
            return $this->redirectToRoute('list_rendez_vous');
        }
        return $this->render('rendez_vous/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/rendez_vous/list', name: 'list_rendez_vous', methods: ['GET'])]
    public function findRendezVous(RendezVousRepository $rendezVousRepository): Response
    {
        $rendezVous=$rendezVousRepository->findAll();
        if (!$rendezVous) {
            throw $this->createNotFoundException('No rendez-vous found');
        }
        return $this->render('rendez_vous/list.html.twig', [
            'rendezVous' => $rendezVous,
        ]);
    }
}
