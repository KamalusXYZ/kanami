<?php

namespace App\Entity;

use App\Repository\MemberEventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberEventRepository::class)]
class MemberEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $arrivalDateTime;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $exitDateTime;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $memberComment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArrivalDateTime(): ?\DateTimeInterface
    {
        return $this->arrivalDateTime;
    }

    public function setArrivalDateTime(?\DateTimeInterface $arrivalDateTime): self
    {
        $this->arrivalDateTime = $arrivalDateTime;

        return $this;
    }

    public function getExitDateTime(): ?\DateTimeInterface
    {
        return $this->exitDateTime;
    }

    public function setExitDateTime(?\DateTimeInterface $exitDateTime): self
    {
        $this->exitDateTime = $exitDateTime;

        return $this;
    }

    public function getMemberComment(): ?string
    {
        return $this->memberComment;
    }

    public function setMemberComment(?string $memberComment): self
    {
        $this->memberComment = $memberComment;

        return $this;
    }
}
