<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $theme;

    #[ORM\Column(type: 'datetime')]
    private $startDateTime;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $endDateTime;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $eventPrice;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $mandatoryBooking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
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

    public function getEndDateTime(): ?\DateTimeInterface
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(?\DateTimeInterface $endDateTime): self
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getEventPrice(): ?string
    {
        return $this->eventPrice;
    }

    public function setEventPrice(?string $eventPrice): self
    {
        $this->eventPrice = $eventPrice;

        return $this;
    }

    public function isMandatoryBooking(): ?bool
    {
        return $this->mandatoryBooking;
    }

    public function setMandatoryBooking(?bool $mandatoryBooking): self
    {
        $this->mandatoryBooking = $mandatoryBooking;

        return $this;
    }
}
