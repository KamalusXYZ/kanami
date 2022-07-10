<?php

namespace App\Entity;

use App\Repository\CategoryDependanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryDependanceRepository::class)]
class CategoryDependance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Item::class, inversedBy: 'categories')]
    private $item;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'items')]
    private $category;

    public function __toString()
    {
        if($this->getCategory() == null) return "Vide";
        return $this->category;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
