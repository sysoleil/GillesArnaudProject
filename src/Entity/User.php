<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message = "Vous devez obligatoirement compléter ce champ")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message = "Vous devez obligatoirement compléter ce champ")
     */
    private $lastName;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Email(message = "Cet email '{{ value }}' n'est pas valide.")
     * @Assert\NotBlank(message = "Une adresse mail est obligatoire.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $club;

    /**
     * @ORM\Column(type="date")
     */
    private $dateBirth;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(min="6", max="20",
     *     minMessage="Votre mot de passe doit comporter au moins 6 caractères",
     *     maxMessage="Votre mot de passe ne doit pas comporter plus de 20 caractères")
     * @Assert\NotBlank(message = "Un mot de passe est obligatoire")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $creditDuration;

    /**
     * @ORM\OneToMany(targetEntity=TicketBook::class, mappedBy="user")
     */
    private $ticketBook;

    public function __construct()
    {
        $this->ticketBook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLevel(): ?float
    {
        return $this->level;
    }

    public function setLevel(?float $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
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

    public function getClub(): ?string
    {
        return $this->club;
    }

    public function setClub(?string $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(\DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCreditDuration(): ?float
    {
        return $this->creditDuration;
    }

    public function setCreditDuration(?float $creditDuration): self
    {
        $this->creditDuration = $creditDuration;

        return $this;
    }

    /**
     * @return Collection|ticketBook[]
     */
    public function getTicketBook(): Collection
    {
        return $this->ticketBook;
    }

    public function addTicketBook(ticketBook $ticketBook): self
    {
        if (!$this->ticketBook->contains($ticketBook)) {
            $this->ticketBook[] = $ticketBook;
            $ticketBook->setUser($this);
        }

        return $this;
    }

    public function removeTicketBook(ticketBook $ticketBook): self
    {
        if ($this->ticketBook->contains($ticketBook)) {
            $this->ticketBook->removeElement($ticketBook);
            // set the owning side to null (unless already changed)
            if ($ticketBook->getUser() === $this) {
                $ticketBook->setUser(null);
            }
        }

        return $this;
    }
}
