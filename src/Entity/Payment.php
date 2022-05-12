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

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private $paymentAmount;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $paymentComment;

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
}
