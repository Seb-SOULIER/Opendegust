<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $address;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $zipCode;

    /**
     * @ORM\Column(type="string", length=90)
     */
    private string $city;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $longitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $latitude;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private ?string $phone2;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $website;

    /**
     * @ORM\OneToOne(targetEntity=Provider::class, mappedBy="contact", cascade={"persist", "remove"})
     */
    private ?Provider $provider;

    /**
     * @ORM\OneToOne(targetEntity=Offer::class, mappedBy="contact", cascade={"persist", "remove"})
     */
    private ?Offer $offer;

    /**
     * @ORM\OneToOne(targetEntity=Customer::class, mappedBy="contact", cascade={"persist", "remove"})
     */
    private ?Customer $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(?string $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function setProvider(?Provider $provider): self
    {
        // unset the owning side of the relation if necessary
        if ($provider === null && $this->provider !== null) {
            $this->provider->setContact(null);
        }

        // set the owning side of the relation if necessary
        if ($provider !== null && $provider->getContact() !== $this) {
            $provider->setContact($this);
        }

        $this->provider = $provider;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(Offer $offer): self
    {
        // set the owning side of the relation if necessary
        if ($offer->getContact() !== $this) {
            $offer->setContact($this);
        }

        $this->offer = $offer;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        // unset the owning side of the relation if necessary
        if ($customer === null && $this->customer !== null) {
            $this->customer->setContact(null);
        }

        // set the owning side of the relation if necessary
        if ($customer !== null && $customer->getContact() !== $this) {
            $customer->setContact($this);
        }

        $this->customer = $customer;

        return $this;
    }
}
