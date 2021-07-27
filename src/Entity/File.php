<?php

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTime;
use Symfony\Component\HttpFoundation\File\File as CoreFile;

/**
 * @ORM\Entity(repositoryClass=FilesRepository::class)
 * @Vich\Uploadable
 */
class File
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $fileName = null;

    /**
     * @ORM\ManyToOne(targetEntity=Provider::class, inversedBy="files")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Provider $provider;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var ?DateTime
     */
    private ?DateTime $updatedAt;

    /**
     * @Vich\UploadableField(mapping="provider_files", fileNameProperty="fileName")
     */
    private ?CoreFile $providerFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

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

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getProviderFile(): ?CoreFile
    {
        return $this->providerFile;
    }

    public function setProviderFile(CoreFile $image = null): self
    {
        $this->providerFile = $image;
        if ($image) {
            $this->setUpdatedAt(new DateTime('now'));
        }
        return $this;
    }
}
