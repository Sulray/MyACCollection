<?php

namespace App\Entity;

use App\Repository\PersonalityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalityRepository::class)]
class Personality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subPersonalities')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $subPersonalities;

    #[ORM\ManyToMany(targetEntity: Card::class, mappedBy: 'personalities')]
    private Collection $cards;

    public function __construct()
    {
        $this->subPersonalities = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    public function __toString() {
        return $this->name;
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubPersonalities(): Collection
    {
        return $this->subPersonalities;
    }

    public function addSubPersonality(self $subPersonality): self
    {
        if (!$this->subPersonalities->contains($subPersonality)) {
            $this->subPersonalities->add($subPersonality);
            $subPersonality->setParent($this);
        }

        return $this;
    }

    public function removeSubPersonality(self $subPersonality): self
    {
        if ($this->subPersonalities->removeElement($subPersonality)) {
            // set the owning side to null (unless already changed)
            if ($subPersonality->getParent() === $this) {
                $subPersonality->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->addPersonality($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->removeElement($card)) {
            $card->removePersonality($this);
        }

        return $this;
    }
}
