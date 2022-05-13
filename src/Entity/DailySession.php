<?php

namespace App\Entity;

use App\Repository\DailySessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailySessionRepository::class)]
class DailySession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $startDateTime;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $endDateTime;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $sessionComment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDateTime(): ?\DateTimeInterface
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(?\DateTimeInterface $startDateTime): self
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

    public function getSessionComment(): ?string
    {
        return $this->sessionComment;
    }

    public function setSessionComment(?string $sessionComment): self
    {
        $this->sessionComment = $sessionComment;

        return $this;
    }
}
