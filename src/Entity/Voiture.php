<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "La marque est obligatoire.")]
    private ?string $marque = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le modèle est obligatoire.")]
    private ?string $modele = null;

    #[ORM\Column(length: 20, unique: true)]
    #[Assert\NotBlank(message: "L'immatriculation est obligatoire.")]
    private ?string $immatriculation = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive(message: "L'année doit être un nombre positif.")]
    private ?int $annee = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personne $proprietaire = null;

    /**
     * @var Collection<int, Assurance>
     */
    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Assurance::class, orphanRemoval: true)]
    private Collection $assurances;

    public function __construct()
    {
        $this->assurances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(?int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getProprietaire(): ?Personne
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Personne $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * @return Collection<int, Assurance>
     */
    public function getAssurances(): Collection
    {
        return $this->assurances;
    }

    public function addAssurance(Assurance $assurance): static
    {
        if (!$this->assurances->contains($assurance)) {
            $this->assurances->add($assurance);
            $assurance->setVoiture($this);
        }

        return $this;
    }

    public function removeAssurance(Assurance $assurance): static
    {
        if ($this->assurances->removeElement($assurance)) {
            // set the owning side to null (unless already changed)
            if ($assurance->getVoiture() === $this) {
                $assurance->setVoiture(null);
            }
        }

        return $this;
    }

    /**
     * Retourne l'assurance actuellement active, si elle existe.
     */
    public function getAssuranceActive(): ?Assurance
    {
        foreach ($this->assurances as $assurance) {
            if ($assurance->isActive()) {
                return $assurance;
            }
        }

        return null;
    }

    public function __toString(): string
    {
        return sprintf('%s %s (%s)', $this->marque, $this->modele, $this->immatriculation);
    }
}
