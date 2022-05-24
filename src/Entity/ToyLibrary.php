<?php

namespace App\Entity;

use App\Repository\ToyLibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToyLibraryRepository::class)]
class ToyLibrary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 45)]
    private $name;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $address;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $zipCode;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $city;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $country;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $legalStatus;

    #[ORM\Column(type: 'integer')]
    private $maxDurationLoanDay;

    #[ORM\Column(type: 'string', length: 45)]
    private $subscriptionType;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private $subscriptionPriceMonth;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $tokenEarnMonth;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private $costMoneyLoad;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private $depositAmount;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private $costMoneyLoan;

    #[ORM\Column(type: 'boolean')]
    private $depositIsCashable;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private $lateCostByDay;

    #[ORM\Column(type: 'integer')]
    private $maxLoanSimultUser;

    #[ORM\Column(type: 'integer')]
    private $maxLoanSimultFamily;

    #[ORM\OneToMany(mappedBy: 'toylibrary', targetEntity: Payment::class)]
    private $payments;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLegalStatus(): ?string
    {
        return $this->legalStatus;
    }

    public function setLegalStatus(?string $legalStatus): self
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

    public function getMaxDurationLoanDay(): ?int
    {
        return $this->maxDurationLoanDay;
    }

    public function setMaxDurationLoanDay(int $maxDurationLoanDay): self
    {
        $this->maxDurationLoanDay = $maxDurationLoanDay;

        return $this;
    }

    public function getSubscriptionType(): ?string
    {
        return $this->subscriptionType;
    }

    public function setSubscriptionType(string $subscriptionType): self
    {
        $this->subscriptionType = $subscriptionType;

        return $this;
    }

    public function getSubscriptionPriceMonth(): ?string
    {
        return $this->subscriptionPriceMonth;
    }

    public function setSubscriptionPriceMonth(?string $subscriptionPriceMonth): self
    {
        $this->subscriptionPriceMonth = $subscriptionPriceMonth;

        return $this;
    }

    public function getTokenEarnMonth(): ?int
    {
        return $this->tokenEarnMonth;
    }

    public function setTokenEarnMonth(?int $tokenEarnMonth): self
    {
        $this->tokenEarnMonth = $tokenEarnMonth;

        return $this;
    }

    public function getCostMoneyLoad(): ?string
    {
        return $this->costMoneyLoad;
    }

    public function setCostMoneyLoad(?string $costMoneyLoad): self
    {
        $this->costMoneyLoad = $costMoneyLoad;

        return $this;
    }

    public function getDepositAmount(): ?string
    {
        return $this->depositAmount;
    }

    public function setDepositAmount(?string $depositAmount): self
    {
        $this->depositAmount = $depositAmount;

        return $this;
    }

    public function getCostMoneyLoan(): ?string
    {
        return $this->costMoneyLoan;
    }

    public function setCostMoneyLoan(?string $costMoneyLoan): self
    {
        $this->costMoneyLoan = $costMoneyLoan;

        return $this;
    }

    public function isDepositIsCashable(): ?bool
    {
        return $this->depositIsCashable;
    }

    public function setDepositIsCashable(bool $depositIsCashable): self
    {
        $this->depositIsCashable = $depositIsCashable;

        return $this;
    }

    public function getLateCostByDay(): ?string
    {
        return $this->lateCostByDay;
    }

    public function setLateCostByDay(?string $lateCostByDay): self
    {
        $this->lateCostByDay = $lateCostByDay;

        return $this;
    }

    public function getMaxLoanSimultUser(): ?int
    {
        return $this->maxLoanSimultUser;
    }

    public function setMaxLoanSimultUser(int $maxLoanSimultUser): self
    {
        $this->maxLoanSimultUser = $maxLoanSimultUser;

        return $this;
    }

    public function getMaxLoanSimultFamily(): ?int
    {
        return $this->maxLoanSimultFamily;
    }

    public function setMaxLoanSimultFamily(int $maxLoanSimultFamily): self
    {
        $this->maxLoanSimultFamily = $maxLoanSimultFamily;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setToylibrary($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getToylibrary() === $this) {
                $payment->setToylibrary(null);
            }
        }

        return $this;
    }
}
