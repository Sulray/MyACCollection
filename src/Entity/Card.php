<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $serie = null;

    #[ORM\Column(length: 255)]
    private ?string $specie = null;

    #[ORM\ManyToOne(inversedBy: 'cartes')]
    private ?Village $village = null;


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

    public function getSerie(): ?int
    {
        return $this->serie;
    }

    public function setSerie(int $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getSpecie(): ?string
    {
        return $this->specie;
    }

    public function setSpecie(string $specie): self
    {
        $this->specie = $specie;

        return $this;
    }

    public function getVillage(): ?Village
    {
        return $this->village;
    }

    public function setVillage(?Village $village): self
    {
        $this->village = $village;

        return $this;
    }

}

