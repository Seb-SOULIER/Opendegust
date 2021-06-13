<?php

namespace App\Entity;

use App\Repository\OfferVariationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferVariationRepository::class)
 */
class OfferVariation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="json")
     */
    private ?string $priceVariation;

    /**
     * @ORM\Column(type="integer")
     */
    private int $capacity;

    /**
     * @ORM\Column(type="time")
     */
    private ?\DateTimeInterface $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private int $price;

    /**
     * @ORM\Column(type="float")
     */
    private float $currentVat;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="offerVariations")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Offer $offer;

    /**
     * @ORM\OneToOne(targetEntity=Booking::class, mappedBy="offerVariation", cascade={"persist", "remove"})
     */
    private ?Booking $booking;

    /**
     * @ORM\OneToOne(targetEntity=Calendar::class, mappedBy="offerVariation", cascade={"persist", "remove"})
     */
    private ?Calendar $calendar;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceVariation(): ?string
    {
        return $this->priceVariation ? json_decode($this->priceVariation) : null;
    }

    public function setPriceVariation(?string $priceVariation): self
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

    public function getCalendar(): ?Calendar
    {
        return $this->calendar;
    }

    public function setCalendar(Calendar $calendar): self
    {
        // set the owning side of the relation if necessary
        if ($calendar->getOfferVariation() !== $this) {
            $calendar->setOfferVariation($this);
        }

        $this->calendar = $calendar;

        return $this;
    }
}
