<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
{
    /**
     * @Groups({"offer"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $picture;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $domainName;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?string $language;

    /**
     * @ORM\ManyToOne(targetEntity=Provider::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Provider $provider;

    /**
     * @ORM\OneToOne(targetEntity=Description::class, cascade={"persist", "remove"})
     */
    private ?Description $description;

    /**
     * @ORM\OneToOne(targetEntity=Contact::class, inversedBy="offer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Contact $contact;


    /**
     * @ORM\OneToMany(targetEntity=OfferVariation::class, mappedBy="offer", orphanRemoval=true)
     */
    private Collection $offerVariations;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="offerId")
     */
    private Collection $categories;

    public function __construct()
    {
        $this->offerVariations = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getDomainName(): ?string
    {
        return $this->domainName;
    }

    public function setDomainName(string $domainName): self
    {
        $this->domainName = $domainName;


        return $this;
    }

    public function getLanguage(): ?array
    {
        return $this->language ? json_decode($this->language, true) : null;
    }

    public function setLanguage(?array $language): self
    {

        $this->language = json_encode($language) === false ? null : json_encode($language);

        return $this;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function setProvider(?Provider $provider): self
    {
        $this->provider = $provider;

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

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection|OfferVariation[]
     */
    public function getOfferVariations(): ?Collection
    {
        return $this->offerVariations;
    }

    public function addOfferVariation(OfferVariation $offerVariation): self
    {
        if (!$this->offerVariations->contains($offerVariation)) {
            $this->offerVariations[] = $offerVariation;
            $offerVariation->setOffer($this);
        }

        return $this;
    }

    public function removeOfferVariation(OfferVariation $offerVariation): self
    {
        if ($this->offerVariations->removeElement($offerVariation)) {
            // set the owning side to null (unless already changed)
            if ($offerVariation->getOffer() === $this) {
                $offerVariation->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addOfferId($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeOfferId($this);
        }

        return $this;
    }
}
