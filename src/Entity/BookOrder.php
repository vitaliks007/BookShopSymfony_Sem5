<?php

namespace App\Entity;

use App\Repository\BookOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookOrderRepository::class)]
class BookOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'bookOrderId', targetEntity: BookOrderProduct::class, orphanRemoval: true)]
    private Collection $bookOrderProducts;

    public function __construct()
    {
        $this->bookOrderProducts = new ArrayCollection();
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, BookOrderProduct>
     */
    public function getBookOrderProducts(): Collection
    {
        return $this->bookOrderProducts;
    }

    public function addBookOrderProduct(BookOrderProduct $bookOrderProduct): self
    {
        if (!$this->bookOrderProducts->contains($bookOrderProduct)) {
            $this->bookOrderProducts->add($bookOrderProduct);
            $bookOrderProduct->setBookOrder($this);
        }

        return $this;
    }

    public function removeBookOrderProduct(BookOrderProduct $bookOrderProduct): self
    {
        if ($this->bookOrderProducts->removeElement($bookOrderProduct)) {
            // set the owning side to null (unless already changed)
            if ($bookOrderProduct->getBookOrder() === $this) {
                $bookOrderProduct->setBookOrder(null);
            }
        }

        return $this;
    }
}
