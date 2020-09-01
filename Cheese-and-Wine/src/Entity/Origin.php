<?php

namespace App\Entity;

use App\Repository\OriginRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OriginRepository::class)
 */
class Origin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"wine_detail", "wines_get", "cheeses_detail", "cheeses_get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"wine_detail", "wines_get", "cheeses_detail", "cheeses_get"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Cheese::class, mappedBy="origin", orphanRemoval=true)
     */
    private $cheeses;

    /**
     * @ORM\OneToMany(targetEntity=Wine::class, mappedBy="origin", orphanRemoval=true)
     */
    private $wines;

    public function __construct()
    {
        $this->cheeses = new ArrayCollection();
        $this->wines = new ArrayCollection();
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

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Cheese[]
     */
    public function getCheeses(): Collection
    {
        return $this->cheeses;
    }

    public function addCheese(Cheese $cheese): self
    {
        if (!$this->cheeses->contains($cheese)) {
            $this->cheeses[] = $cheese;
            $cheese->setorigin($this);
        }

        return $this;
        
    }

    public function removeCheese(Cheese $cheese): self
    {
        if ($this->cheeses->contains($cheese)) {
            $this->cheeses->removeElement($cheese);
            // set the owning side to null (unless already changed)
            if ($cheese->getorigin() === $this) {
                $cheese->setorigin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Wine[]
     */
    public function getWines(): Collection
    {
        return $this->wines;
    }

    public function addWine(Wine $wine): self
    {
        if (!$this->wines->contains($wine)) {
            $this->wines[] = $wine;
            $wine->setorigin($this);
        }

        return $this;
    }

    public function removeWine(Wine $wine): self
    {
        if ($this->wines->contains($wine)) {
            $this->wines->removeElement($wine);
            // set the owning side to null (unless already changed)
            if ($wine->getorigin() === $this) {
                $wine->setorigin(null);
            }
        }

        return $this;
    }
}
