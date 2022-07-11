<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $paymentDate;

    #[ORM\Column(type: 'string', length: 45)]
    private $paymentKind;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2,nullable: true)]
    private $paymentAmount;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $paymentComment;

    #[ORM\ManyToOne(targetEntity: Family::class, inversedBy: 'payment')]
    private $family;

    #[ORM\ManyToOne(targetEntity: ToyLibrary::class, inversedBy: 'payments')]
    private $toylibrary;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $paymentCause;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getPaymentKind(): ?string
    {
        return $this->paymentKind;
    }

    public function setPaymentKind(string $paymentKind): self
    {
        $this->paymentKind = $paymentKind;

        return $this;
    }

    public function getPaymentAmount(): ?string
    {
        return $this->paymentAmount;
    }

    public function setPaymentAmount(string $paymentAmount): self
    {
        $this->paymentAmount = $paymentAmount;

        return $this;
    }

    public function getPaymentComment(): ?string
    {
        return $this->paymentComment;
    }

    public function setPaymentComment(?string $paymentComment): self
    {
        $this->paymentComment = $paymentComment;

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

    public function getToylibrary(): ?ToyLibrary
    {
        return $this->toylibrary;
    }

    public function setToylibrary(?ToyLibrary $toylibrary): self
    {
        $this->toylibrary = $toylibrary;

        return $this;
    }

    public function getPaymentCause(): ?string
    {
        return $this->paymentCause;
    }

    public function setPaymentCause(?string $paymentCause): self
    {
        $this->paymentCause = $paymentCause;

        return $this;
    }
}
