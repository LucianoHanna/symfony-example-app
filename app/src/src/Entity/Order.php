<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tableIdentifier = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $orderedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deliveredAt = null;

    #[ORM\OneToMany(mappedBy: 'orderRel', targetEntity: OrderItem::class, cascade: ['persist'])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTableIdentifier(): ?string
    {
        return $this->tableIdentifier;
    }

    public function setTableIdentifier(string $tableIdentifier): static
    {
        $this->tableIdentifier = $tableIdentifier;

        return $this;
    }

    public function getOrderedAt(): ?\DateTimeImmutable
    {
        return $this->orderedAt;
    }

    public function setOrderedAt(\DateTimeImmutable $orderedAt): static
    {
        $this->orderedAt = $orderedAt;

        return $this;
    }

    public function getDeliveredAt(): ?\DateTimeImmutable
    {
        return $this->deliveredAt;
    }

    public function setDeliveredAt(\DateTimeImmutable $deliveredAt): static
    {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrderRel($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrderRel() === $this) {
                $item->setOrderRel(null);
            }
        }

        return $this;
    }
}
