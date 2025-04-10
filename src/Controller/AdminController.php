<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRoleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        
        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }
    
    #[Route('/user/{id}/edit', name: 'app_admin_user_edit')]
    public function editUser(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserRoleFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Utilisateur mis à jour avec succès!');
            return $this->redirectToRoute('app_admin');
        }
        
        return $this->render('admin/edit_user.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/user/{id}/toggle-active', name: 'app_admin_user_toggle_active')]
    public function toggleUserActive(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setIsIsActive(!$user->isIsActive());
        $entityManager->flush();
        
        $status = $user->isIsActive() ? 'activé' : 'désactivé';
        $this->addFlash('success', "L'utilisateur a été $status avec succès!");
        
        return $this->redirectToRoute('app_admin');
    }
}