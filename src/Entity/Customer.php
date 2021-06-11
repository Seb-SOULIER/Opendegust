<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTimeInterface $birthdate;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?string $knowUs;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $gtc18;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?string $favory;

    /**
     * @ORM\OneToOne(targetEntity=Contact::class, inversedBy="customer", cascade={"persist", "remove"})
     */
    private ?Contact $contact;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="customer")
     */
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getKnowUs(): ?array
    {
        return $this->knowUs ? json_decode($this->knowUs) : null;
    }

    public function setKnowUs(?string $knowUs): self
    {
        $this->knowUs = $knowUs;

        return $this;
    }

    public function getGtc18(): ?bool
    {
        return $this->gtc18;
    }

    public function setGtc18(bool $gtc18): self
    {
        $this->gtc18 = $gtc18;

        return $this;
    }

    public function getFavory(): ?array
    {
        return $this->favory ? json_decode($this->favory) : null;
    }

    public function setFavory(?string $favory): self
    {
        $this->favory = $favory;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): ?Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setCustomer($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCustomer() === $this) {
                $booking->setCustomer(null);
            }
        }

        return $this;
    }
}
