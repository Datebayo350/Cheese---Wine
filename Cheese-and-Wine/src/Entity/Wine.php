<?php

namespace App\Entity;

use App\Repository\WineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=WineRepository::class)
 */
class Wine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"wines_get", "wine_detail","data","cheeses_detail","cheeses_get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"wines_get", "wine_detail","data","cheeses_detail","cheeses_get"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"wines_get", "wine_detail","data","cheeses_detail","cheeses_get"})
     */
    private $appellation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"wines_get","wine_detail","data","cheeses_detail","cheeses_get"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     * @Groups({"wines_get","wine_detail","data","cheeses_detail","cheeses_get"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"wines_get","wine_detail","data","cheeses_detail","cheeses_get"})
     */
    private $type;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"wines_get","wine_detail","data","cheeses_detail","cheeses_get"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Origin::class, inversedBy="wines", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"wine_detail", "wines_get", "cheeses_detail", "cheeses_get"})
     */
    private $origin;

    /**
     * @ORM\ManyToMany(targetEntity=Cheese::class, mappedBy="wines")
     * @Groups({"wine_detail", "wines_get"})
     */
    private $cheeses;



    public function __construct()
    {
        $this->cheeses = new ArrayCollection();
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

    public function getAppellation(): ?string
    {
        return $this->appellation;
    }

    public function setAppellation(string $appellation): self
    {
        $this->appellation = $appellation;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

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

    public function addCheeses(Cheese $cheese): self
    {
        if (!$this->cheeses->contains($cheese)) {
            $this->cheeses[] = $cheese;
            $cheese->addWines($this);
        }

        return $this;
    }

    public function removeCheeses(Cheese $cheese): self
    {
        if ($this->cheeses->contains($cheese)) {
            $this->cheeses->removeElement($cheese);
            $cheese->removeWines($this);
        }

        return $this;
    }

    public function getorigin(): ?Origin
    {
        return $this->origin;
    }

    public function setorigin(?Origin $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}