<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "La compagnie est obligatoire.")]
    private ?string $compagnie = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: "Le numéro de contrat est obligatoire.")]
    private ?string $numeroContrat = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull(message: "La date de début est obligatoire.")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull(message: "La date de fin est obligatoire.")]
    #[Assert\GreaterThan(
        propertyPath: 'dateDebut',
        message: "La date de fin doit être postérieure à la date de début."
    )]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    #[Assert\Positive(message: "Le montant doit être positif.")]
    private ?float $montant = null;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $active = true;

    #[ORM\ManyToOne(inversedBy: 'assurances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voiture $voiture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompagnie(): ?string
    {
        return $this->compagnie;
    }

    public function setCompagnie(string $compagnie): static
    {
        $this->compagnie = $compagnie;

        return $this;
    }

    public function getNumeroContrat(): ?string
    {
        return $this->numeroContrat;
    }

    public function setNumeroContrat(string $numeroContrat): static
    {
        $this->numeroContrat = $numeroContrat;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): static
    {
        $this->voiture = $voiture;

        return $this;
    }

    /**
     * Indique si le contrat d'assurance est expiré à la date actuelle.
     */
    public function estExpiree(): bool
    {
        return $this->dateFin !== null && $this->dateFin < new \DateTime('now');
    }

    public function __toString(): string
    {
        return sprintf('%s - %s', $this->compagnie, $this->numeroContrat);
    }
}
