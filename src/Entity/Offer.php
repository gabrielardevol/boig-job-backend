<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Enum\ContractTypeEnum;
use App\Enum\StateEnum;
use App\Enum\TypologyEnum;
use App\Entity\OfferResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ApiFilter(OrderFilter::class, properties: ['company', 'role', 'appliedAt', 'state'], arguments: ['orderParameterName' => 'order'])]
#[ORM\Entity]
class Offer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private string $id;

    #[ORM\Column(length: 10000, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $role = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $experienceMinimum = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $experienceMaximum = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $skills = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $salaryMinimum = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $salaryMaximum = null;

    #[ORM\OneToMany(targetEntity: OfferResponse::class, mappedBy: 'offer', cascade: ['persist', 'remove'])]
    private Collection $responses;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $appliedAt = null;

    #[ORM\Column(type: 'string', enumType: ContractTypeEnum::class, nullable: true)]
    private ?ContractTypeEnum $contractType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recruiter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $platform = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: 'string', nullable: true, enumType: TypologyEnum::class)]
    private ?TypologyEnum $typology = null;

    #[ORM\Column(type: 'string', nullable: true, enumType: StateEnum::class)]
    private ?StateEnum $state = StateEnum::WAITING_FOR_RESPONSE;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getExperienceMinimum(): ?int
    {
        return $this->experienceMinimum;
    }

    public function setExperienceMinimum(?int $experienceMinimum): self
    {
        $this->experienceMinimum = $experienceMinimum;
        return $this;
    }

    public function getExperienceMaximum(): ?int
    {
        return $this->experienceMaximum;
    }

    public function setExperienceMaximum(?int $experienceMaximum): self
    {
        $this->experienceMaximum = $experienceMaximum;
        return $this;
    }

    public function getSkills(): ?array
    {
        return $this->skills;
    }

    public function setSkills(?array $skills): self
    {
        $this->skills = $skills;
        return $this;
    }

    public function getSalaryMinimum(): ?int
    {
        return $this->salaryMinimum;
    }

    public function setSalaryMinimum(?int $salaryMinimum): self
    {
        $this->salaryMinimum = $salaryMinimum;
        return $this;
    }

    public function getSalaryMaximum(): ?int
    {
        return $this->salaryMaximum;
    }

    public function setSalaryMaximum(?int $salaryMaximum): self
    {
        $this->salaryMaximum = $salaryMaximum;
        return $this;
    }

    /**
     * @return Collection<int, OfferResponse>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(OfferResponse $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setOffer($this);
        }

        return $this;
    }

    public function removeResponse(OfferResponse $response): self
    {
        if ($this->responses->removeElement($response)) {
            if ($response->getOffer() === $this) {
                $response->setOffer(null);
            }
        }

        return $this;
    }

    public function getAppliedAt(): ?\DateTimeInterface
    {
        return $this->appliedAt;
    }

    public function setAppliedAt(?\DateTimeInterface $appliedAt): self
    {
        $this->appliedAt = $appliedAt;
        return $this;
    }

    public function getContractType(): ?ContractTypeEnum
    {
        return $this->contractType;
    }

    public function setContractType(?ContractTypeEnum $contractType): self
    {
        $this->contractType = $contractType;
        return $this;
    }

    public function getRecruiter(): ?string
    {
        return $this->recruiter;
    }

    public function setRecruiter(?string $recruiter): self
    {
        $this->recruiter = $recruiter;
        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(?string $platform): self
    {
        $this->platform = $platform;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getTypology(): ?TypologyEnum
    {
        return $this->typology;
    }

    public function setTypology(?TypologyEnum $typology): self
    {
        $this->typology = $typology;
        return $this;
    }

    public function getState(): ?StateEnum
    {
        return $this->state;
    }

    public function setState(?StateEnum $state): static
    {
        $this->state = $state;

        return $this;
    }
}
