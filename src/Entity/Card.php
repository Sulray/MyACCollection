<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column]
    private ?int $series = null;

    #[ORM\Column(length: 255)]
    private ?string $species = null;

    #[ORM\ManyToOne(inversedBy: 'cards')]
    private ?Village $village = null;

    #[ORM\ManyToMany(targetEntity: Personality::class, inversedBy: 'cards')]
    private Collection $personalities;

    #[ORM\ManyToMany(targetEntity: Gallery::class, mappedBy: 'cards')]
    private Collection $galleries;

    public function __construct()
    {
        $this->personalities = new ArrayCollection();
        $this->galleries = new ArrayCollection();
    }


    public function __toString() {
        return $this->name . " (" . $this->species . ")";
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


    public function getSeries(): ?int
    {
        return $this->series;
    }

    public function setSeries(int $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(string $species): self
    {
        $this->species = $species;

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

    /**
     * @return Collection<int, Personality>
     */
    public function getPersonalities(): Collection
    {
        return $this->personalities;
    }

    public function addPersonality(Personality $personality): self
    {
        if (!$this->personalities->contains($personality)) {
            $this->personalities->add($personality);
        }

        return $this;
    }

    public function removePersonality(Personality $personality): self
    {
        $this->personalities->removeElement($personality);

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Gallery $gallery): self
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries->add($gallery);
            $gallery->addCard($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): self
    {
        if ($this->galleries->removeElement($gallery)) {
            $gallery->removeCard($this);
        }

        return $this;
    }

}

