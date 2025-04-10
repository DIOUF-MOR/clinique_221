<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function profile(): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }
        
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
    
    #[Route('/profile/edit', name: 'app_user_profile_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }
        
        // Créez un formulaire pour éditer le profil (vous devrez le créer)
        $form = $this->createForm(UserProfileType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Si un nouveau mot de passe est fourni, le hasher
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $plainPassword
                );
                $user->setPassword($hashedPassword);
            }
            
            $entityManager->flush();
            
            $this->addFlash('success', 'Votre profil a été mis à jour avec succès!');
            return $this->redirectToRoute('app_user_profile');
        }
        
        return $this->render('user/edit_profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}/view', name: 'app_user_view')]
    public function viewUser(User $user): Response
    {
        // Utilisation du voter
        $this->denyAccessUnlessGranted('view', $user, 'Vous n\'avez pas la permission de voir ce profil!');
        
        return $this->render('user/view.html.twig', [
            'user' => $user,
        ]);
    }
}