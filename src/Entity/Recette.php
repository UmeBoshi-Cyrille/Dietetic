<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
#[UniqueEntity('name')]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank()]
    private string $description;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank()]
    #[Assert\Positive()]
    #[Assert\LessThan(90)]
    private ?int $preparationTime;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(90)]
    private ?int $restTime;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Positive()]
    #[Assert\LessThan(90)]
    private ?int $cookingTime;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank()]
    private string $step;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private ?DateTimeImmutable $publishedAt;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $isPublished;

    #[ORM\ManyToMany(targetEntity: Regime::class)]
    private $regimes;

    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    private $ingredients;

    #[ORM\ManyToMany(targetEntity: Allergene::class)]
    private $allergenes;

    public function __construct()
    {
        $this->publishedAt = new DateTimeImmutable();
        $this->regimes = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->allergenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPreparationTime(): ?string
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(?string $preparationTime): self
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getRestTime(): ?string
    {
        return $this->restTime;
    }

    public function setRestTime(?string $restTime): self
    {
        $this->restTime = $restTime;

        return $this;
    }

    public function getCookingTime(): ?string
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?string $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getStep(): ?string
    {
        return $this->step;
    }

    public function setStep(string $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return Collection<int, Regime>
     */
    public function getRegimes(): Collection
    {
        return $this->regimes;
    }

    public function addRegime(Regime $regime): self
    {
        if (!$this->regimes->contains($regime)) {
            $this->regimes[] = $regime;
        }

        return $this;
    }

    public function removeRegime(Regime $regime): self
    {
        $this->regimes->removeElement($regime);

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    /**
     * @return Collection<int, Allergene>
     */
    public function getAllergenes(): Collection
    {
        return $this->allergenes;
    }

    public function addAllergene(Allergene $allergene): self
    {
        if (!$this->allergenes->contains($allergene)) {
            $this->allergenes[] = $allergene;
        }

        return $this;
    }

    public function removeAllergene(Allergene $allergene): self
    {
        $this->allergenes->removeElement($allergene);

        return $this;
    }
}
