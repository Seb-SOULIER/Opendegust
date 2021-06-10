<?php

namespace App\Entity;

use App\Repository\ProviderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProviderRepository::class)
 */
class Provider extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;


    /**
     * @ORM\Column(type="string", length=45)
     */
    private string $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $picture;


    /**
     * @ORM\Column(type="string", length=45)
     */
    private string $socialReason;


    /**
     * @ORM\Column(type="integer")
     */
    private int $siret;


    /**
     * @ORM\Column(type="integer")
     */
    private int $vatNumber;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?string $opening;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $monthlyFrequentation;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?string $otherSite;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?string $knowUs;

    /**
     * @ORM\OneToMany(targetEntity=Offer::class, mappedBy="provider", orphanRemoval=true)
     */
    private Collection $offers;


    /**
     * @ORM\OneToOne(targetEntity=Description::class, cascade={"persist", "remove"})
     */
    private ?Description $description;

    /**
     * @ORM\OneToOne(targetEntity=Contact::class, inversedBy="provider", cascade={"persist", "remove"})
     */
    private ?Contact $contact;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="provider")
     */
    private Collection $products;

    /**
     * @ORM\OneToMany(targetEntity=Files::class, mappedBy="provider", orphanRemoval=true)
     */
    private Collection $files;


    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSocialReason(): ?string
    {
        return $this->socialReason;
    }

    public function setSocialReason(string $socialReason): self
    {
        $this->socialReason = $socialReason;

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getVatNumber(): ?int
    {
        return $this->vatNumber;
    }

    public function setVatNumber(int $vatNumber): self
    {
        $this->vatNumber = $vatNumber;

        return $this;
    }

    public function getOpening(): ?array
    {
        return $this->opening ? json_decode($this->opening) : null;
    }

    public function setOpening(?string $opening): self
    {
        $this->opening = $opening;

        return $this;
    }


    public function getMonthlyFrequentation(): ?int
    {
        return $this->monthlyFrequentation;
    }

    public function setMonthlyFrequentation(?int $monthlyFrequentation): self
    {
        $this->monthlyFrequentation = $monthlyFrequentation;

        return $this;
    }

    public function getOtherSite(): ?array
    {
        return $this->otherSite ? json_decode($this->otherSite) : null;
    }

    public function setOtherSite(?string $otherSite): self
    {
        $this->otherSite = $otherSite;

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

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setProvider($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getProvider() === $this) {
                $offer->setProvider(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?Description
    {
        return $this->description;
    }

    public function setDescription(?Description $description): self
    {
        $this->description = $description;

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
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setProvider($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getProvider() === $this) {
                $product->setProvider(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Files[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(Files $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setProvider($this);
        }

        return $this;
    }

    public function removeFile(Files $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getProvider() === $this) {
                $file->setProvider(null);
            }
        }

        return $this;
    }
}
