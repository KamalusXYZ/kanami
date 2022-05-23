<?php

namespace App\Entity;

use App\Repository\MemberDailySessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberDailySessionRepository::class)]
class MemberDailySession
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

    #[ORM\OneToMany(mappedBy: 'MemberDailySession', targetEntity: Member::class)]
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setMemberDailySession($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getMemberDailySession() === $this) {
                $member->setMemberDailySession(null);
            }
        }

        return $this;
    }
}
