<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $registerDate;

    #[ORM\Column(type: 'integer')]
    private $maxLoanSimultaneous;

    #[ORM\Column(type: 'boolean')]
    private $delayWarning;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $delayWarningNb;

    #[ORM\Column(type: 'boolean')]
    private $incompleteReturn;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $incompleteReturnNb;

    #[ORM\Column(type: 'boolean')]
    private $blocked;

    #[ORM\Column(type: 'boolean')]
    private $paymentOk;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tokenAvailable;

    #[ORM\Column(type: 'boolean')]
    private $deposit;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $depositInformation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTimeInterface $registerDate): self
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getMaxLoanSimultaneous(): ?int
    {
        return $this->maxLoanSimultaneous;
    }

    public function setMaxLoanSimultaneous(int $maxLoanSimultaneous): self
    {
        $this->maxLoanSimultaneous = $maxLoanSimultaneous;

        return $this;
    }

    public function isDelayWarning(): ?bool
    {
        return $this->delayWarning;
    }

    public function setDelayWarning(bool $delayWarning): self
    {
        $this->delayWarning = $delayWarning;

        return $this;
    }

    public function getDelayWarningNb(): ?int
    {
        return $this->delayWarningNb;
    }

    public function setDelayWarningNb(?int $delayWarningNb): self
    {
        $this->delayWarningNb = $delayWarningNb;

        return $this;
    }

    public function isIncompleteReturn(): ?bool
    {
        return $this->incompleteReturn;
    }

    public function setIncompleteReturn(bool $incompleteReturn): self
    {
        $this->incompleteReturn = $incompleteReturn;

        return $this;
    }

    public function getIncompleteReturnNb(): ?int
    {
        return $this->incompleteReturnNb;
    }

    public function setIncompleteReturnNb(?int $incompleteReturnNb): self
    {
        $this->incompleteReturnNb = $incompleteReturnNb;

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): self
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function isPaymentOk(): ?bool
    {
        return $this->paymentOk;
    }

    public function setPaymentOk(bool $paymentOk): self
    {
        $this->paymentOk = $paymentOk;

        return $this;
    }

    public function getTokenAvailable(): ?int
    {
        return $this->tokenAvailable;
    }

    public function setTokenAvailable(?int $tokenAvailable): self
    {
        $this->tokenAvailable = $tokenAvailable;

        return $this;
    }

    public function isDeposit(): ?bool
    {
        return $this->deposit;
    }

    public function setDeposit(bool $deposit): self
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function getDepositInformation(): ?string
    {
        return $this->depositInformation;
    }

    public function setDepositInformation(string $depositInformation): self
    {
        $this->depositInformation = $depositInformation;

        return $this;
    }
}
