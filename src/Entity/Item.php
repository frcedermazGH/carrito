<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Producto $producto = null;

    #[ORM\ManyToOne(inversedBy: 'item')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orden $orden = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): static
    {
        $this->producto = $producto;

        return $this;
    }

    public function getOrden(): ?Orden
    {
        return $this->orden;
    }

    public function setOrden(?Orden $orden): static
    {
        $this->orden = $orden;

        return $this;
    }

    public function getTotal(): ?float
    {
        if ($this->producto !== null && $this->cantidad !== null) {
            return $this->cantidad * $this->producto->getPrecio();
        }
    
        return null;
    }

    public function equals(Item $item)
    {
        $productoUno = $item->getProducto();
        $productoDos = $this->getProducto();
        if ($productoUno->getId() == $productoDos->getId()) {
            return true;
        } else {
            return false;
        }
    }
}
