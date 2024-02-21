<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Nem::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $nem;

    public function __construct()
    {
        $this->nem = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Nem>
     */
    public function getNem(): Collection
    {
        return $this->nem;
    }

    public function addNem(Nem $nem): static
    {
        if (!$this->nem->contains($nem)) {
            $this->nem->add($nem);
            $nem->setCategory($this);
        }

        return $this;
    }

    public function removeNem(Nem $nem): static
    {
        if ($this->nem->removeElement($nem)) {
            // set the owning side to null (unless already changed)
            if ($nem->getCategory() === $this) {
                $nem->setCategory(null);
            }
        }

        return $this;
    }
}
