<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\AssessmentStatus;
use App\Repository\AssessmentRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssessmentRepository::class)]
class Assessment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Inspector $inspector;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Job $job;

    #[ORM\Column(length: 255, nullable: false, enumType: AssessmentStatus::class)]
    private AssessmentStatus $status;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private \DateTimeInterface $assigned_date;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private \DateTimeInterface $delivery_date;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(type:"datetime")]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type:"datetime")]
    private ?DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInspector(): Inspector
    {
        return $this->inspector;
    }

    public function setInspector(Inspector $inspector): static
    {
        $this->inspector = $inspector;

        return $this;
    }

    public function getJob(): Job
    {
        return $this->job;
    }

    public function setJob(Job $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status->value;
    }

    public function setStatus(AssessmentStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAssignedDate(): \DateTimeInterface
    {
        return $this->assigned_date;
    }

    public function setAssignedDate(\DateTimeInterface $assigned_date): static
    {
        $this->assigned_date = $assigned_date;

        return $this;
    }

    public function getDeliveryDate(): \DateTimeInterface
    {
        return $this->delivery_date;
    }

    public function setDeliveryDate(\DateTimeInterface $delivery_date): static
    {
        $this->delivery_date = $delivery_date;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist()]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable('now');
    }

    #[ORM\PreUpdate()]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable('now');
    }
}
