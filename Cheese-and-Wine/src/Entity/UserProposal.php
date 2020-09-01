<?php

namespace App\Entity;

use App\Repository\UserProposalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserProposalRepository::class)
 */
class UserProposal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_proposal_get"})
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_proposal_get"})
     */
    private $mainProduct;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_proposal_get"})
     */
    private $associatedProduct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }


    /**
     * Get the value of mainProduct
     */ 
    public function getMainProduct()
    {
        return $this->mainProduct;
    }

    /**
     * Set the value of mainProduct
     *
     * @return  self
     */ 
    public function setMainProduct($mainProduct)
    {
        $this->mainProduct = $mainProduct;

        return $this;
    }

    /**
     * Get the value of associatedProduct
     */ 
    public function getAssociatedProduct()
    {
        return $this->associatedProduct;
    }

    /**
     * Set the value of associatedProduct
     *
     * @return  self
     */ 
    public function setAssociatedProduct($associatedProduct)
    {
        $this->associatedProduct = $associatedProduct;

        return $this;
    }
}
