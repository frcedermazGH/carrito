<?php

namespace App\Manager;

use App\Entity\Usuario;
use App\Entity\Orden;
use App\Repository\ItemRepository;
use App\Repository\OrdenRepository;
use DateTime;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrdenManager
{
    private $productoRepository;
    private $ordenRepository;
    private $entityManager;
    private $itemRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductoRepository $prodRep, OrdenRepository $ordenRep, ItemRepository $itemRep)
    {
        $this->productoRepository = $prodRep;
        $this->ordenRepository = $ordenRep;
        $this->itemRepository = $itemRep;
        $this->entityManager = $entityManager;
    }

    function agregarProducto(Usuario $usuario, int $idProducto, int $cantidad)
    {
        $orden = $this->obtenerOrden($usuario, 'Iniciada');
        $producto = $this->productoRepository->find($idProducto);
        if ($orden == null) {
            $orden = new Orden();
            $orden->setEstado('Iniciada');
            $now = new DateTime();
            $orden->setIniciada($now);
            $orden->setUsuario($usuario);
        }
        $item = $orden->agregarItem($producto, $cantidad);
        $this->entityManager->persist($item);
        $this->entityManager->persist($orden);
        $this->entityManager->flush();
    }

    private function obtenerOrden(Usuario $usuario, string $estado)
    {
        $ordenEncontrada = $this->ordenRepository->findOneBy(['usuario' => $usuario, 'estado' => $estado]);
        return $ordenEncontrada;
    }

    function verOrden(Usuario $usuario)
    {
        $orden = $this->ordenRepository->findOneBy(['usuario' => $usuario, 'estado' => 'Iniciada']);
        return $orden;
    }

    function finalizarCompra(Usuario $usuario)
    {
        $orden = $this->ordenRepository->findOneBy(['usuario' => $usuario, 'estado' => 'Iniciada']);
        $orden->setEstado("Finalizada");
        $now = new DateTime();
        $orden->setConfirmada($now);
        $this->entityManager->flush();
        return $orden;
    }

    function eliminarItem(Usuario $usuario, string $idItem){
        $orden = $this->ordenRepository->findOneBy(['usuario' => $usuario, 'estado' => 'Iniciada']);
        $item = $this->itemRepository->find($idItem);
        $orden->removeItem($item);
        $this->entityManager->remove($item);
        $this->entityManager->flush();
    }

    function vaciarOrden(Usuario $usuario){
        $orden = $this->ordenRepository->findOneBy(['usuario' => $usuario, 'estado' => 'Iniciada']);
        $item = $orden->getItem();
        foreach ($item as $element) {
            $orden->removeItem($element);
            $this->entityManager->remove($element);
        }
        $this->entityManager->flush();
    }
}
