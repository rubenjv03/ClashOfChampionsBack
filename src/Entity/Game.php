<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $game_name = null;

    #[ORM\Column(length: 25)]
    private ?string $game_platform = null;

    #[ORM\Column(length: 15)]
    private ?string $game_format = null;

    #[ORM\Column(length: 255)]
    private ?string $game_description = null;

    #[ORM\Column(type: Types::BLOB)]
    private $game_img = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameName(): ?string
    {
        return $this->game_name;
    }

    public function setGameName(string $game_name): self
    {
        $this->game_name = $game_name;

        return $this;
    }

    public function getGamePlatform(): ?string
    {
        return $this->game_platform;
    }

    public function setGamePlatform(string $game_platform): self
    {
        $this->game_platform = $game_platform;

        return $this;
    }

    public function getGameFormat(): ?string
    {
        return $this->game_format;
    }

    public function setGameFormat(string $game_format): self
    {
        $this->game_format = $game_format;

        return $this;
    }

    public function getGameDescription(): ?string
    {
        return $this->game_description;
    }

    public function setGameDescription(string $game_description): self
    {
        $this->game_description = $game_description;

        return $this;
    }

    public function getGameImg()
    {
        return $this->game_img;
    }

    public function setGameImg($game_img): self
    {
        $this->game_img = $game_img;

        return $this;
    }
}
