<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $ref;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $lang;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $publisherGameDuration;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $ourGameDuration;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $playerNbMin;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $playerNbMax;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ageMin;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $author;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $illustrator;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $publisher;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $itemCondition;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $completeness;

    #[ORM\Column(type: 'boolean')]
    private $available;

    #[ORM\Column(type: 'boolean')]
    private $archive;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $updatePseudoUser;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $UpdateDateTime;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $archivePseudoUser;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $archiveDateTime;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $archiveCause;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $archiveGameBecome;

    #[ORM\Column(type: 'decimal', precision: 2, scale: 1, nullable: true)]
    private $memberItemRatingTotal;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $memberItemRatingNb;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2, nullable: true)]
    private $gamePrice;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $gameOrigin;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $userMadeEntry;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $copyNumber;

    #[ORM\Column(type: 'datetime')]
    private $registerDateTime;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: CategoryDependance::class)]
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(?string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(?string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getPublisherGameDuration(): ?string
    {
        return $this->publisherGameDuration;
    }

    public function setPublisherGameDuration(?string $publisherGameDuration): self
    {
        $this->publisherGameDuration = $publisherGameDuration;

        return $this;
    }

    public function getOurGameDuration(): ?string
    {
        return $this->ourGameDuration;
    }

    public function setOurGameDuration(?string $ourGameDuration): self
    {
        $this->ourGameDuration = $ourGameDuration;

        return $this;
    }

    public function getPlayerNbMin(): ?int
    {
        return $this->playerNbMin;
    }

    public function setPlayerNbMin(?int $playerNbMin): self
    {
        $this->playerNbMin = $playerNbMin;

        return $this;
    }

    public function getPlayerNbMax(): ?int
    {
        return $this->playerNbMax;
    }

    public function setPlayerNbMax(?int $playerNbMax): self
    {
        $this->playerNbMax = $playerNbMax;

        return $this;
    }

    public function getAgeMin(): ?int
    {
        return $this->ageMin;
    }

    public function setAgeMin(?int $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIllustrator(): ?string
    {
        return $this->illustrator;
    }

    public function setIllustrator(?string $illustrator): self
    {
        $this->illustrator = $illustrator;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getItemCondition(): ?string
    {
        return $this->itemCondition;
    }

    public function setItemCondition(?string $itemCondition): self
    {
        $this->itemCondition = $itemCondition;

        return $this;
    }

    public function isCompleteness(): ?bool
    {
        return $this->completeness;
    }

    public function setCompleteness(?bool $completeness): self
    {
        $this->completeness = $completeness;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function isArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getUpdatePseudoUser(): ?string
    {
        return $this->updatePseudoUser;
    }

    public function setUpdatePseudoUser(?string $updatePseudoUser): self
    {
        $this->updatePseudoUser = $updatePseudoUser;

        return $this;
    }

    public function getUpdateDateTime(): ?\DateTimeInterface
    {
        return $this->UpdateDateTime;
    }

    public function setUpdateDateTime(?\DateTimeInterface $UpdateDateTime): self
    {
        $this->UpdateDateTime = $UpdateDateTime;

        return $this;
    }

    public function getArchivePseudoUser(): ?string
    {
        return $this->archivePseudoUser;
    }

    public function setArchivePseudoUser(?string $archivePseudoUser): self
    {
        $this->archivePseudoUser = $archivePseudoUser;

        return $this;
    }

    public function getArchiveDateTime(): ?\DateTimeInterface
    {
        return $this->archiveDateTime;
    }

    public function setArchiveDateTime(?\DateTimeInterface $archiveDateTime): self
    {
        $this->archiveDateTime = $archiveDateTime;

        return $this;
    }

    public function getArchiveCause(): ?string
    {
        return $this->archiveCause;
    }

    public function setArchiveCause(?string $archiveCause): self
    {
        $this->archiveCause = $archiveCause;

        return $this;
    }

    public function getArchiveGameBecome(): ?string
    {
        return $this->archiveGameBecome;
    }

    public function setArchiveGameBecome(?string $archiveGameBecome): self
    {
        $this->archiveGameBecome = $archiveGameBecome;

        return $this;
    }

    public function getMemberItemRatingTotal(): ?string
    {
        return $this->memberItemRatingTotal;
    }

    public function setMemberItemRatingTotal(?string $memberItemRatingTotal): self
    {
        $this->memberItemRatingTotal = $memberItemRatingTotal;

        return $this;
    }

    public function getMemberItemRatingNb(): ?int
    {
        return $this->memberItemRatingNb;
    }

    public function setMemberItemRatingNb(?int $memberItemRatingNb): self
    {
        $this->memberItemRatingNb = $memberItemRatingNb;

        return $this;
    }

    public function getGamePrice(): ?string
    {
        return $this->gamePrice;
    }

    public function setGamePrice(?string $gamePrice): self
    {
        $this->gamePrice = $gamePrice;

        return $this;
    }

    public function getGameOrigin(): ?string
    {
        return $this->gameOrigin;
    }

    public function setGameOrigin(?string $gameOrigin): self
    {
        $this->gameOrigin = $gameOrigin;

        return $this;
    }

    public function getUserMadeEntry(): ?string
    {
        return $this->userMadeEntry;
    }

    public function setUserMadeEntry(?string $userMadeEntry): self
    {
        $this->userMadeEntry = $userMadeEntry;

        return $this;
    }

    public function getCopyNumber(): ?int
    {
        return $this->copyNumber;
    }

    public function setCopyNumber(?int $copyNumber): self
    {
        $this->copyNumber = $copyNumber;

        return $this;
    }

    public function getRegisterDateTime(): ?\DateTimeInterface
    {
        return $this->registerDateTime;
    }

    public function setRegisterDateTime(\DateTimeInterface $registerDateTime): self
    {
        $this->registerDateTime = $registerDateTime;

        return $this;
    }

    /**
     * @return Collection<int, CategoryDependance>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(CategoryDependance $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setItem($this);
        }

        return $this;
    }

    public function removeCategory(CategoryDependance $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getItem() === $this) {
                $category->setItem(null);
            }
        }

        return $this;
    }
}
