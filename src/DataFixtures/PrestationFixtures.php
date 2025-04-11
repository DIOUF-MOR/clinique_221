<?php

namespace App\DataFixtures;

use App\Entity\Prestation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PrestationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $rv = new Prestation();
            $rv->setDateCreation(new \DateTime());
            $rv->setDateHeure(new \DateTime(+$i.'days 10:00'));
            
            $rv->setPatient($this->getReference("Patient".$i,Patient::class));
            $rv->setStatut("En attente");
            $manager->persist($rv);
            $this->addReference("RendezVous".$i, $rv);
        }
        $manager->flush();
    }
}
