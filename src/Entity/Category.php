<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private string $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $parentId;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="category")
     */
    private Collection $products;

    /**
     * @ORM\ManyToMany(targetEntity=Offer::class, inversedBy="categories")
     */
    private Collection $offerId;


    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->offerId = new ArrayCollection();
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

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Offer[]
     */
    public function getOfferId(): Collection
    {
        return $this->offerId;
    }

    public function addOfferId(Offer $offerId): self
    {
        if (!$this->offerId->contains($offerId)) {
            $this->offerId[] = $offerId;
        }

        return $this;
    }

    public function removeOfferId(Offer $offerId): self
    {
        $this->offerId->removeElement($offerId);

        return $this;
    }
}
