<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = new Patient();
            $user->setEmail("patient{$i}@example.com");
            $user->setPrenom("Patient");
            $user->setNom("Number {$i}");
            $user->setCodePatient("P00{$i}");
            $user->setDossierMedical(null); // Assuming you want to set it to null for now
            $user->setIsIsActive(true);
            $user->setRoles(['ROLE_PATIENT']);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                'user123'
            ));
            $manager->persist($user);
            $this->addReference("Patient".$i, $user);
        }

        $manager->flush();
    }
}
