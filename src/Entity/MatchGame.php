<?php

namespace App\Entity;

use App\Repository\MatchGameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchGameRepository::class)]
class MatchGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time_start = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time_max = null;

    #[ORM\Column]
    private ?int $tournament_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->time_start;
    }

    public function setTimeStart(\DateTimeInterface $time_start): self
    {
        $this->time_start = $time_start;

        return $this;
    }

    public function getTimeMax(): ?\DateTimeInterface
    {
        return $this->time_max;
    }

    public function setTimeMax(\DateTimeInterface $time_max): self
    {
        $this->time_max = $time_max;

        return $this;
    }

    public function getTournamentId(): ?int
    {
        return $this->tournament_id;
    }

    public function setTournamentId(int $tournament_id): self
    {
        $this->tournament_id = $tournament_id;

        return $this;  
    }
}
