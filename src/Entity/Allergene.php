<?php

namespace App\Entity;

use App\Repository\AllergeneRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AllergeneRepository::class)]
#[UniqueEntity('name')]
class Allergene
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 75)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 55)]
    private string $name;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank()]
    private string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $publishedAt;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $isPublished;

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function __toString()
    {
        return $this->name;
    }
}
