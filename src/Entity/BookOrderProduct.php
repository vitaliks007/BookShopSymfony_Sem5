<?php

namespace App\Entity;

use App\Repository\BookOrderProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookOrderProductRepository::class)]
class BookOrderProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cost = null;

    #[ORM\Column]
    private ?int $count = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'bookOrderProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BookOrder $bookOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getBookOrder(): ?BookOrder
    {
        return $this->bookOrder;
    }

    public function setBookOrder(?BookOrder $bookOrder): self
    {
        $this->bookOrder = $bookOrder;

        return $this;
    }
}
