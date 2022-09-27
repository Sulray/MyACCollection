<?php

namespace App\Entity;

use App\Repository\VillageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VillageRepository::class)]
class Village
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'village', targetEntity: Card::class, cascade: ["persist"])]
    private Collection $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

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

    /**
     * @return Village<int, Card>
     */
    public function getCards(): Village
    {
        return $this->cartes;
    }

    public function addCard(Card $carte): self
    {
        if (!$this->cartes->contains($carte)) {
            $this->cartes->add($carte);
            $carte->setVillage($this);
        }

        return $this;
    }

    public function removeCard(Card $carte): self
    {
        if ($this->cartes->removeElement($carte)) {
            // set the owning side to null (unless already changed)
            if ($carte->getVillage() === $this) {
                $carte->setVillage(null);
            }
        }

        return $this;
    }
}
