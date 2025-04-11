<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation extends RendezVous
{
    #[ORM\Column(length: 255)]
    private ?string $observations = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?DossierMedical $dossierMedical = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Medecin $medecin = null;

    /**
     * @var Collection<int, Constante>
     */
    #[ORM\OneToMany(targetEntity: Constante::class, mappedBy: 'consultation')]
    private Collection $constantes;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Ordonnance $ordonnance = null;

    public function __construct()
    {
        $this->constantes = new ArrayCollection();
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(string $observations): static
    {
        $this->observations = $observations;

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

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    /**
     * @return Collection<int, Constante>
     */
    public function getConstantes(): Collection
    {
        return $this->constantes;
    }

    public function addConstante(Constante $constante): static
    {
        if (!$this->constantes->contains($constante)) {
            $this->constantes->add($constante);
            $constante->setConsultation($this);
        }

        return $this;
    }

    public function removeConstante(Constante $constante): static
    {
        if ($this->constantes->removeElement($constante)) {
            // set the owning side to null (unless already changed)
            if ($constante->getConsultation() === $this) {
                $constante->setConsultation(null);
            }
        }

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): static
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }
}
