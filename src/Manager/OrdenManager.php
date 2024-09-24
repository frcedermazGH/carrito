<?php

namespace App\Manager;

use App\Entity\Usuario;
use App\Entity\Orden;
use DateTime;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrdenManager
{
    private $productoRepository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ProductoRepository $prodRep)
    {
        $this->productoRepository = $prodRep;
        $this->entityManager = $entityManager;
    }

    function agregarProducto(Usuario $usuario, int $idProducto, int $cantidad)
    {
        $orden = new Orden();
        $orden->setEstado('Iniciada');
        $now = new DateTime();
        $orden->setIniciada($now);
        $orden->setUsuario($usuario);
        $producto = $this->productoRepository->find($idProducto);

        $item = $orden->agregarItem($producto, $cantidad);

        $this->entityManager->persist($orden);
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }
}
