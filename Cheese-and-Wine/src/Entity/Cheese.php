<?php

namespace App\Entity;

use App\Repository\CheeseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CheeseRepository::class)
 */
class Cheese
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"cheeses_get","cheeses_detail","data", "wine_detail", "wines_get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Groups({"cheeses_get","cheeses_detail","data", "wine_detail", "wines_get"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cheeses_get","cheeses_detail","data", "wine_detail", "wines_get"})
     */
    private $milk;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"cheeses_get","cheeses_detail","data", "wine_detail", "wines_get"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     * @Groups({"cheeses_get","cheeses_detail","data", "wine_detail", "wines_get"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"cheeses_get","cheeses_detail","data", "wine_detail", "wines_get"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Origin::class, inversedBy="cheeses", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @Groups ({"cheeses_detail","cheeses_get", "wines_get", "wine_detail"})
     */
    private $origin;

    /**
     * @ORM\ManyToMany(targetEntity=Wine::class, inversedBy="cheeses")
     * @Groups ({"cheeses_detail","cheeses_get"})
     */
    private $wines;


    public function __construct()
    {
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

    public function getMilk(): ?string
    {
        return $this->milk;
    }

    public function setMilk(string $milk): self
    {
        $this->milk = $milk;

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
     * @return Collection|Wine[]
     */
    //! Ce getter doit toujours avoir un S dans son nom
    //! Merci Raphaël :D
    public function getWines(): Collection
    {
        return $this->wines;
    }

    public function addWines(Wine $wines): self
    {
        if (!$this->wines->contains($wines)) {
            $this->wines[] = $wines;
        }

        return $this;
    }

    public function removeWines(Wine $wines): self
    {
        if ($this->wines->contains($wines)) {
            $this->wines->removeElement($wines);
        }

        return $this;
    }

    public function getOrigin(): ?Origin
    {
        return $this->origin;
    }

    public function setOrigin(?Origin $origin)
    {
        $this->origin = $origin;

        return $this;
    }
}
