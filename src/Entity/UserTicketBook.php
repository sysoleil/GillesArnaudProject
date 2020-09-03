<?php

namespace App\Entity;

use App\Repository\UserTicketBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserTicketBookRepository::class)
 */
class UserTicketBook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datePurchase;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="userTicketBook")
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity=TicketBook::class, mappedBy="userTicketBook")
     */
    private $TicketBook;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->TicketBook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePurchase(): ?\DateTimeInterface
    {
        return $this->datePurchase;
    }

    public function setDatePurchase(?\DateTimeInterface $datePurchase): self
    {
        $this->datePurchase = $datePurchase;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
            $user->setUserTicketBook($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->User->contains($user)) {
            $this->User->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUserTicketBook() === $this) {
                $user->setUserTicketBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TicketBook[]
     */
    public function getTicketBook(): Collection
    {
        return $this->TicketBook;
    }

    public function addTicketBook(TicketBook $ticketBook): self
    {
        if (!$this->TicketBook->contains($ticketBook)) {
            $this->TicketBook[] = $ticketBook;
            $ticketBook->setUserTicketBook($this);
        }

        return $this;
    }

    public function removeTicketBook(TicketBook $ticketBook): self
    {
        if ($this->TicketBook->contains($ticketBook)) {
            $this->TicketBook->removeElement($ticketBook);
            // set the owning side to null (unless already changed)
            if ($ticketBook->getUserTicketBook() === $this) {
                $ticketBook->setUserTicketBook(null);
            }
        }

        return $this;
    }
}
