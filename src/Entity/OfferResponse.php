<?php

namespace App\Entity;

// src/Entity/OfferResponse.php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Offer;
use App\Enum\ResponseTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ApiResource]
#[ORM\Entity]
class OfferResponse
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private string $id;

    #[ORM\Column(type: 'text')]
    private string $text;

    #[ORM\Column(type: 'string', enumType: ResponseTypeEnum::class)]
    private ResponseTypeEnum $type;

    #[ORM\ManyToOne(targetEntity: Offer::class, inversedBy: 'responses')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Offer $offer = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 10000, nullable: true)]
    private ?string $originalContent = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getType(): ResponseTypeEnum
    {
        return $this->type;
    }

    public function setType(ResponseTypeEnum $type): self
    {
        $this->type = $type;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOriginalContent(): ?string
    {
        return $this->originalContent;
    }

    public function setOriginalContent(?string $originalContent): static
    {
        $this->originalContent = $originalContent;

        return $this;
    }
}
