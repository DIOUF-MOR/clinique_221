<?php
// src/Security/UserVoter.php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Bundle\SecurityBundle\Security;

class UserVoter extends Voter
{
    const EDIT = 'edit';
    const VIEW = 'view';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // Si ce n'est pas l'un des attributs que nous gérons, on ne vote pas
        if (!in_array($attribute, [self::EDIT, self::VIEW])) {
            return false;
        }

        // Seuls les objets User sont supportés
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // L'utilisateur doit être connecté
        if (!$user instanceof User) {
            return false;
        }

        // SUPER_ADMIN peut tout faire
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        // On récupère l'utilisateur sur lequel on va voter
        $userSubject = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($userSubject, $user);
            case self::EDIT:
                return $this->canEdit($userSubject, $user);
        }

        throw new \LogicException('Cette ligne ne devrait jamais être atteinte!');
    }

    private function canView(User $userSubject, User $user): bool
    {
        // Un utilisateur peut toujours voir son propre profil
        if ($user === $userSubject) {
            return true;
        }

        // Les administrateurs peuvent voir tous les profils
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return false;
    }

    private function canEdit(User $userSubject, User $user): bool
    {
        // Un utilisateur peut toujours modifier son propre profil
        if ($user === $userSubject) {
            return true;
        }

        // Seul un admin peut modifier d'autres profils
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return false;
    }
}