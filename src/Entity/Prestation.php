<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
class Prestation extends RendezVous
{
   
    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 100)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $resultat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRealisation = null;

    #[ORM\ManyToOne(inversedBy: 'prestations')]
    private ?ResponsablePrestation $responsablePrestation = null;

    #[ORM\ManyToOne(inversedBy: 'prestations')]
    private ?DossierMedical $dossierMedical = null;


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getResultat(): ?string
    {
        return $this->resultat;
    }

    public function setResultat(string $resultat): static
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getDateRealisation(): ?\DateTimeInterface
    {
        return $this->dateRealisation;
    }

    public function setDateRealisation(\DateTimeInterface $dateRealisation): static
    {
        $this->dateRealisation = $dateRealisation;

        return $this;
    }


    public function getResponsablePrestation(): ?ResponsablePrestation
    {
        return $this->responsablePrestation;
    }

    public function setResponsablePrestation(?ResponsablePrestation $responsablePrestation): static
    {
        $this->responsablePrestation = $responsablePrestation;

        return $this;
    }

    public function getDossierMedical(): ?DossierMedical
    {
        return $this->dossierMedical;
    }

    public function setDossierMedical(?DossierMedical $dossierMedical): static
    {
        $this->dossierMedical = $dossierMedical;

        return $this;
    }
}
