<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GenreRepository;
use Doctrine\ORM\Mapping as ORM;
#[ApiResource]
#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 31)]
    private ?string $genreName = null;

    #[ORM\Column(length: 31, nullable: true)]
    private ?string $genreNameRus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenreName(): ?string
    {
        return $this->genreName;
    }

    public function setGenreName(string $genreName): self
    {
        $this->genreName = $genreName;

        return $this;
    }

    public function getGenreNameRus(): ?string
    {
        return $this->genreNameRus;
    }

    public function setGenreNameRus(?string $genreNameRus): self
    {
        $this->genreNameRus = $genreNameRus;

        return $this;
    }
}
