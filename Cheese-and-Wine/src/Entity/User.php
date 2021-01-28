<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
/**
 * @ORM\Id()
 * @ORM\GeneratedValue()
 * @ORM\Column(type="integer")
 * @Groups({"users_get", "user_detail"})
 */
private $id;

/**
 * @ORM\Column(type="string", length=180)
 * @Groups({"users_get", "user_detail"})
 * @Assert\NotBlank
 * @Assert\Email
 */
private $email;

/**
 * @ORM\Column(type="string", length=180)
 * @Groups({"users_get", "user_detail"})
 * @Assert\NotBlank
 */
private $password;

/**
 * @ORM\Column(type="string", length=45)
 * @Groups({"users_get","user_detail"})
 */
private $name;

/**
 * @ORM\Column(type="json")
 * @Groups({"users_get", "user_detail"})
 * @Assert\Count(min=1)
 */
private $roles = [];

/**
 * @ORM\Column(type="datetime", nullable=true)
 * @Groups({"users_get","user_detail"})
 */
private $createdAt;

/**
 * @ORM\Column(type="datetime", nullable=true)
 */
private $updatedAt;

/**
* @ORM\Column(type="string", unique=true, nullable=true)
* @Groups({"users_get","user_detail"})
*/
private $apiToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
        
    }



    /**
     * Get the value of apiToken
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }
    /**
     * Set the value of apiToken
     *
     * @return  self
     */
    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;
        return $this;
    }
    public function generateApiToken()
    {
       $this->apiToken;
        
    }
}