<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use DateTimeImmutable;
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
    #[Assert\NotNull()]
    private $description;

    #[ORM\Column(type: 'string', length: 75)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 75)]
    private string $preparationTime;

    #[ORM\Column(type: 'string', length: 75, nullable: true)]
    #[Assert\Length(min: 2, max: 75)]
    private string $restTime;

    #[ORM\Column(type: 'string', length: 75, nullable: true)]
    #[Assert\Length(min: 2, max: 75)]
    private string $cookingTime;

    #[ORM\Column(type: 'text')]
    #[Assert\NotNull()]
    private $step;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private ?DateTimeImmutable $publishedAt;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isPublished;

    public function __construct()
    {
        $this->publishedAt = new DateTimeImmutable();
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
}
