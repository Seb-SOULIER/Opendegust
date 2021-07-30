<?php

namespace App\Entity;

use App\Repository\CalendarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CalendarRepository::class)
 */
class Calendar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $startAt;

    /**
     * @ORM\ManyToOne(targetEntity=OfferVariation::class, inversedBy="calendars")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?OfferVariation $offerVariation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $availablePlaces;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

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
