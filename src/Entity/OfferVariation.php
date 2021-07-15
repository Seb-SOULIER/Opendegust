<?php

namespace App\Entity;

use App\Repository\OfferVariationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OfferVariationRepository::class)
 */
class OfferVariation
{
    /**
     * @Groups({"offerVariation"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Groups({"offerVariation"})
     * @ORM\Column(type="json")
     */
    private string $priceVariation;

    /**
     * @Groups({"offerVariation"})
     * @ORM\Column(type="integer")
     */
    private int $capacity;

    /**
     * @Groups({"offerVariation"})
     * @ORM\Column(type="time")
     */
    private ?\DateTimeInterface $duration;

    /**
     * @Groups({"offerVariation"})
     * @ORM\Column(type="integer")
     */
    private int $price;

    /**
     * @Groups({"offerVariation"})
     * @ORM\Column(type="float")
     */
    private float $currentVat;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="offerVariations")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Offer $offer;

    /**
     * @Groups({"offerVariation"})
     * @ORM\OneToOne(targetEntity=Booking::class, mappedBy="offerVariation", cascade={"persist", "remove"})
     */
    private ?Booking $booking;

    /**
     * @Groups({"offerVariation"})
     * @ORM\OneToMany(targetEntity=Calendar::class, mappedBy="offerVariation", orphanRemoval=true)
     */
    private Collection $calendars;

    /**
     * @Groups({"offerVariation"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $availablePlaces;

    public function __construct()
    {
        $this->calendars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceVariation(): array
    {
        return json_decode($this->priceVariation, true);
    }

    public function setPriceVariation(string $priceVariation): self
    {
        $this->priceVariation = $priceVariation ;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrentVat(): ?float
    {
        return $this->currentVat;
    }

    public function setCurrentVat(float $currentVat): self
    {
        $this->currentVat = $currentVat;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): self
    {
        // unset the owning side of the relation if necessary
        if ($booking === null && $this->booking !== null) {
            $this->booking->setOfferVariation(null);
        }

        // set the owning side of the relation if necessary
        if ($booking !== null && $booking->getOfferVariation() !== $this) {
            $booking->setOfferVariation($this);
        }

        $this->booking = $booking;

        return $this;
    }

    /**
     * @return Collection|Calendar[]
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): self
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars[] = $calendar;
            $calendar->setOfferVariation($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): self
    {
        if ($this->calendars->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getOfferVariation() === $this) {
                $calendar->setOfferVariation(null);
            }
        }

        return $this;
    }

    public function getAvailablePlaces(): ?int
    {
        return $this->availablePlaces;
    }

    public function setAvailablePlaces(?int $availablePlaces): self
    {
        $this->availablePlaces = $availablePlaces;

        return $this;
    }
}
