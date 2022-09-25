<?php

namespace App\Entity;

use App\Contract\Model\TerrainInterface;
use App\Repository\TerrainRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerrainRepository::class)]
class Terrain implements TerrainInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $attackerModifier = null;

    #[ORM\Column]
    private ?float $defenderModifier = null;

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

    public function getAttackerModifier(): ?float
    {
        return $this->attackerModifier;
    }

    public function setAttackerModifier(float $attackerModifier): self
    {
        $this->attackerModifier = $attackerModifier;

        return $this;
    }

    public function getDefenderModifier(): ?float
    {
        return $this->defenderModifier;
    }

    public function setDefenderModifier(float $defenderModifier): self
    {
        $this->defenderModifier = $defenderModifier;

        return $this;
    }
}
