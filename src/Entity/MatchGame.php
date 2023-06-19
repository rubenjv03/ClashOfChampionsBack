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

    #[ORM\Column(length: 30)]
    private ?string $time_start = null;

    #[ORM\Column(length: 30)]
    private ?string $time_max = null;

    #[ORM\Column]
    private ?int $tournament_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $participant1_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $participant2_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeStart(): ?string
    {
        return $this->time_start;
    }

    public function setTimeStart(string $time_start): self
    {
        $this->time_start = $time_start;

        return $this;
    }

    public function getTimeMax(): ?string
    {
        return $this->time_max;
    }

    public function setTimeMax(string $time_max): self
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

    public function getParticipant1Name(): ?string
    {
        return $this->participant1_name;
    }

    public function setParticipant1Name(?string $participant1_name): self
    {
        $this->participant1_name = $participant1_name;

        return $this;
    }

    public function getParticipant2Name(): ?string
    {
        return $this->participant2_name;
    }

    public function setParticipant2Name(?string $participant2_name): self
    {
        $this->participant2_name = $participant2_name;

        return $this;
    }
}
