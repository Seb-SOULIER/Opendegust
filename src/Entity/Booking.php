<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
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
    private ?string $places;

    /**
     * @ORM\Column(type="json")
     */
    private ?string $priceVariationBook;

    /**
     * @ORM\Column(type="float")
     */
    private float $totalPrice;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $vat;

    /**
     * @ORM\Column(type="integer")
     */
    private int $totalPlaces;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="bookings")
     */
    private Customer $customer;

    /**
     * @ORM\OneToOne(targetEntity=OfferVariation::class, inversedBy="booking", cascade={"persist", "remove"})
     */
    private ?OfferVariation $offerVariation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaces(): ?array
    {
        return $this->places ? json_decode($this->places, true) : null;
    }

    public function setPlaces(?array $places): self
    {
        $this->places = json_encode($places) === false ? null : json_encode($places);

        return $this;
    }

    public function getPriceVariationBook(): ?array
    {
        return $this->priceVariationBook ? json_decode($this->priceVariationBook, true) : null;
    }

    public function setPriceVariationBook(?array $priceVariationBook): self
    {
        $this->priceVariationBook =
            json_encode($priceVariationBook) === false ? null : json_encode($priceVariationBook);

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(?float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getTotalPlaces(): ?int
    {
        return $this->totalPlaces;
    }

    public function setTotalPlaces(int $totalPlaces): self
    {
        $this->totalPlaces = $totalPlaces;

        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getOfferVariation(): ?OfferVariation
    {
        return $this->offerVariation;
    }

    public function setOfferVariation(?OfferVariation $offerVariation): self
    {
        $this->offerVariation = $offerVariation;

        return $this;
    }
}
