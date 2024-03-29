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

    #[ORM\OneToMany(mappedBy: 'village', targetEntity: Card::class, cascade: ["persist"])]
    private Collection $cards;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'villages')]
    private ?Member $member = null;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function __toString() {
        return $this->name . " (" . $this->id . ")";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $carte): self
    {
        if (!$this->cards->contains($carte)) {
            $this->cards->add($carte);
            $carte->setVillage($this);
        }

        return $this;
    }

    public function removeCard(Card $carte): self
    {
        if ($this->cards->removeElement($carte)) {
            // set the owning side to null (unless already changed)
            if ($carte->getVillage() === $this) {
                $carte->setVillage(null);
            }
        }

        return $this;
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

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }
}
