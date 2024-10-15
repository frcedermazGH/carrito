<?php

namespace App\Entity;

use App\Repository\OrdenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdenRepository::class)]
class Orden
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $estado = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $iniciada = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $confirmada = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'orden')]
    private Collection $item;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getIniciada(): ?\DateTimeInterface
    {
        return $this->iniciada;
    }

    public function setIniciada(\DateTimeInterface $iniciada): static
    {
        $this->iniciada = $iniciada;

        return $this;
    }

    public function getConfirmada(): ?\DateTimeInterface
    {
        return $this->confirmada;
    }

    public function setConfirmada(?\DateTimeInterface $confirmada): static
    {
        $this->confirmada = $confirmada;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItem(): Collection
    {
        return $this->item;
    }

    public function addItem(Item $item)
    {
        foreach ($this->item as $element) {
            if ($element->equals(($item))) {
                $element->setCantidad($item->getCantidad());
                return $element;
            }
        }


        if (!$this->item->contains($item)) {
            $this->item->add($item);
            $item->setOrden($this);
        }

        return $item;
    }

    public function agregarItem(Producto $producto, int $cantidad)
    {
        $item = new Item();
        $item->setProducto($producto);
        $item->setCantidad($cantidad);
        $item = $this->addItem($item);
        return $item;
    }

    public function removeItem(Item $item): static
    {
        if ($this->item->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrden() === $this) {
                $item->setOrden(null);
            }
        }

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getTotal(){
        $total = 0.0;

        foreach ($this->item as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }
}
