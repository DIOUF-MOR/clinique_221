<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient extends User
{
    #[ORM\Column(length: 25)]
    private ?string $codePatient = null;

    #[ORM\OneToOne(mappedBy: 'patient', cascade: ['persist', 'remove'])]
    private ?DossierMedical $dossierMedical = null;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'patient')]
    private Collection $rendezVous;

    public function __construct()
    {
        $this->rendezVous = new ArrayCollection();
    }


    public function getCodePatient(): ?string
    {
        return $this->codePatient;
    }

    public function setCodePatient(string $codePatient): static
    {
        $this->codePatient = $codePatient;

        return $this;
    }

    public function getDossierMedical(): ?DossierMedical
    {
        return $this->dossierMedical;
    }

    public function setDossierMedical(?DossierMedical $dossierMedical): static
    {
        // unset the owning side of the relation if necessary
        if ($dossierMedical === null && $this->dossierMedical !== null) {
            $this->dossierMedical->setPatient(null);
        }

        // set the owning side of the relation if necessary
        if ($dossierMedical !== null && $dossierMedical->getPatient() !== $this) {
            $dossierMedical->setPatient($this);
        }

        $this->dossierMedical = $dossierMedical;

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVou(RendezVous $rendezVou): static
    {
        if (!$this->rendezVous->contains($rendezVou)) {
            $this->rendezVous->add($rendezVou);
            $rendezVou->setPatient($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): static
    {
        if ($this->rendezVous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getPatient() === $this) {
                $rendezVou->setPatient(null);
            }
        }

        return $this;
    }
}
