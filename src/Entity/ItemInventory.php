<?php

namespace App\Entity;

use App\Repository\ItemInventoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemInventoryRepository::class)]
class ItemInventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isChecked;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $whoChecked;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $checkDateTime;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $checkComment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsChecked(): ?bool
    {
        return $this->isChecked;
    }

    public function setIsChecked(?bool $isChecked): self
    {
        $this->isChecked = $isChecked;

        return $this;
    }

    public function getWhoChecked(): ?string
    {
        return $this->whoChecked;
    }

    public function setWhoChecked(?string $whoChecked): self
    {
        $this->whoChecked = $whoChecked;

        return $this;
    }

    public function getCheckDateTime(): ?\DateTimeInterface
    {
        return $this->checkDateTime;
    }

    public function setCheckDateTime(?\DateTimeInterface $checkDateTime): self
    {
        $this->checkDateTime = $checkDateTime;

        return $this;
    }

    public function getCheckComment(): ?string
    {
        return $this->checkComment;
    }

    public function setCheckComment(?string $checkComment): self
    {
        $this->checkComment = $checkComment;

        return $this;
    }
}
