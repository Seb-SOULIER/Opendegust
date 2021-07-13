<?php

namespace App\Entity;

use DateTime;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable
 */
class Product
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
    private ?string $name = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $picture = null;

    /**
     * @Vich\UploadableField(mapping="img_product", fileNameProperty="picture")
     * @Assert\File(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/png", "image/webp"},
     * )
     * @var ?File
     */
    private ?File $imgProduct;

    /**
     * @return ?File
     */
    public function getImgProduct(): ?File
    {
        return $this->imgProduct;
    }

    public function setImgProduct(?File $image = null): self
    {
        $this->imgProduct = $image;
        if ($image) {
            $this->updateAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @ORM\Column(type="float")
     */
    private float $price;

    /**
     * @ORM\ManyToOne(targetEntity=Provider::class, inversedBy="products")
     */
    private ?Provider $provider;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Category $category;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updateAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): ?self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;
        return $this;
    }
}
