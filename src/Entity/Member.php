<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 45)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 45)]
    private $lastName;

    #[ORM\Column(type: 'date')]
    private $birthday;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $phone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $address;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $zipCode;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $city;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $country;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $otherAddressDetail;

    #[ORM\ManyToOne(targetEntity: Relationship::class, inversedBy: 'members')]
    private $relationShip;

    #[ORM\ManyToOne(targetEntity: MemberEvent::class, inversedBy: 'members')]
    private $memberEvent;

    #[ORM\ManyToOne(targetEntity: MemberDailySession::class, inversedBy: 'members')]
    private $MemberDailySession;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Relationship::class)]
    private $relationships;

    public function __construct()
    {
        $this->relationships = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getOtherAddressDetail(): ?string
    {
        return $this->otherAddressDetail;
    }

    public function setOtherAddressDetail(?string $otherAddressDetail): self
    {
        $this->otherAddressDetail = $otherAddressDetail;

        return $this;
    }

    public function getRelationShip(): ?Relationship
    {
        return $this->relationShip;
    }

    public function setRelationShip(?Relationship $relationShip): self
    {
        $this->relationShip = $relationShip;

        return $this;
    }

    public function getMemberEvent(): ?MemberEvent
    {
        return $this->memberEvent;
    }

    public function setMemberEvent(?MemberEvent $memberEvent): self
    {
        $this->memberEvent = $memberEvent;

        return $this;
    }

    public function getMemberDailySession(): ?MemberDailySession
    {
        return $this->MemberDailySession;
    }

    public function setMemberDailySession(?MemberDailySession $MemberDailySession): self
    {
        $this->MemberDailySession = $MemberDailySession;

        return $this;
    }

    /**
     * @return Collection<int, Relationship>
     */
    public function getRelationships(): Collection
    {
        return $this->relationships;
    }

    public function addRelationship(Relationship $relationship): self
    {
        if (!$this->relationships->contains($relationship)) {
            $this->relationships[] = $relationship;
            $relationship->setMember($this);
        }

        return $this;
    }

    public function removeRelationship(Relationship $relationship): self
    {
        if ($this->relationships->removeElement($relationship)) {
            // set the owning side to null (unless already changed)
            if ($relationship->getMember() === $this) {
                $relationship->setMember(null);
            }
        }

        return $this;
    }
}
