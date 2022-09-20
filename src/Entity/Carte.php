<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteRepository::class)]
class Carte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $série = null;

    #[ORM\Column(length: 255)]
    private ?string $espèce = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSérie(): ?int
    {
        return $this->série;
    }

    public function setSérie(int $série): self
    {
        $this->série = $série;

        return $this;
    }

    public function getEspèce(): ?string
    {
        return $this->espèce;
    }

    public function setEspèce(string $espèce): self
    {
        $this->espèce = $espèce;

        return $this;
    }
}
