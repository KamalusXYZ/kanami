<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
class Loan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $startDateTime;

    #[ORM\Column(type: 'date')]
    private $datePreviewBack;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $effectReturnDateTime;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $completenessReturn;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $returnComment;

    #[ORM\ManyToOne(targetEntity: Family::class, inversedBy: 'loan')]
    private $family;

    #[ORM\ManyToOne(targetEntity: Item::class, inversedBy: 'loans')]
    private $item;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(\DateTimeInterface $startDateTime): self
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getDatePreviewBack(): ?\DateTimeInterface
    {
        return $this->datePreviewBack;
    }

    public function setDatePreviewBack(\DateTimeInterface $datePreviewBack): self
    {
        $this->datePreviewBack = $datePreviewBack;

        return $this;
    }

    public function getEffectReturnDateTime(): ?\DateTimeInterface
    {
        return $this->effectReturnDateTime;
    }

    public function setEffectReturnDateTime(?\DateTimeInterface $effectReturnDateTime): self
    {
        $this->effectReturnDateTime = $effectReturnDateTime;

        return $this;
    }

    public function isCompletenessReturn(): ?bool
    {
        return $this->completenessReturn;
    }

    public function setCompletenessReturn(?bool $completenessReturn): self
    {
        $this->completenessReturn = $completenessReturn;

        return $this;
    }

    public function getReturnComment(): ?string
    {
        return $this->returnComment;
    }

    public function setReturnComment(?string $returnComment): self
    {
        $this->returnComment = $returnComment;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}
