<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Village::class, cascade: ["persist"])]
    private Collection $villages;

    public function __construct()
    {
        $this->villages = new ArrayCollection();
    }

    public function __toString() {
        return $this->name . " (" . $this->id . ")";
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

    /**
     * @return Collection<int, village>
     */
    public function getVillages(): Collection
    {
        return $this->villages;
    }

    public function addVillage(village $village): self
    {
        if (!$this->villages->contains($village)) {
            $this->villages->add($village);
            $village->setMember($this);
        }

        return $this;
    }

    public function removeVillage(village $village): self
    {
        if ($this->villages->removeElement($village)) {
            // set the owning side to null (unless already changed)
            if ($village->getMember() === $this) {
                $village->setMember(null);
            }
        }

        return $this;
    }
}
