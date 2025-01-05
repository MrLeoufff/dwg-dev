<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length : 255)]
    #[Assert\Choice(choices: ['site_web', 'formation'], message: 'Choisissez un type valide.')]
    private ?string $type = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type : 'json', nullable: true)]
    private ?array $sessions = [];

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate( ? \DateTimeInterface $startDate) : self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getSessions(): ?array
    {
        return $this->sessions;
    }

    public function setSessions(array $sessions): self
    {
        $this->sessions = $sessions;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFormattedSessions(): array
    {
        $formattedSessions = [];
        foreach ($this->sessions as $session) {
            $formattedSessions[] = [
                'day' => new \DateTime($session['day']),
                'startTime' => new \DateTime($session['startTime']),
                'duration' => $session['duration'],
            ];
        }
        return $formattedSessions;
    }

}
