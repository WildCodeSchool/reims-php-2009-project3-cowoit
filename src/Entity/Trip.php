<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TripRepository::class)
 */
class Trip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $addressStart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $addressEnd;

    /**
     * @ORM\Column(type="integer")
     */
    private int $nbPassengers;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $driver;

    /**
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="trip")
     */
    private ArrayCollection $participations;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAddressStart(): ?string
    {
        return $this->addressStart;
    }

    public function setAddressStart(string $addressStart): self
    {
        $this->addressStart = $addressStart;

        return $this;
    }

    public function getAddressEnd(): ?string
    {
        return $this->addressEnd;
    }

    public function setAddressEnd(string $addressEnd): self
    {
        $this->addressEnd = $addressEnd;

        return $this;
    }

    public function getNbPassengers(): ?int
    {
        return $this->nbPassengers;
    }

    public function setNbPassengers(int $nbPassengers): self
    {
        $this->nbPassengers = $nbPassengers;

        return $this;
    }

    public function getDriver(): ?User
    {
        return $this->driver;
    }

    public function setDriver(?User $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setTrip($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getTrip() === $this) {
                $participation->setTrip(null);
            }
        }

        return $this;
    }
}
