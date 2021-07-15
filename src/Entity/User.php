<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Datetime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 * @UniqueEntity(fields={"email"}, message="Cette adresse email existe déjà")
 */
abstract class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Veuillez indiquer une adresse email")
     * @Assert\Email(
     *     message = "L'adresse '{{ value }}' n'est pas valide.")
     * @Assert\Length(
     *     max="180",
     *     maxMessage="L'adresse email est trop longue, elle ne devrait pas dépasser {{ limit }} caractères")
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles;


    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    private string $password;

//    private string $plainPassword;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $registrationAt;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $civility;


    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Assert\Length(
     *     max="45",
     *     maxMessage="Le nom est trop long, il ne devrait pas dépasser {{ limit }} caractères")
     */
    private string $lastname;


    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Assert\Length(
     *     max="45",
     *     maxMessage="Le prénom est trop long, il ne devrait pas dépasser {{ limit }} caractères")
     */
    private string $firstname;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVerified = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $facebookId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $googleId;

    /**
     * @return int
     */
    public function getId(): int
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
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRegistrationAt(): ?DateTime
    {
        return $this->registrationAt;
    }

    public function setRegistrationAt(DateTime $registrationAt): self
    {
        $this->registrationAt = $registrationAt;

        return $this;
    }

    public function getCivility(): ?int
    {
        return $this->civility;
    }

    public function setCivility(int $civility): self
    {
        $this->civility = $civility;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(string $facebookId): self
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(string $googleId): self
    {
        $this->googleId = $googleId;

        return $this;
    }
}
