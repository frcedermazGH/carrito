<?php
namespace App\Manager;
use App\Repository\ProductoRepository;

class ProductoManager
{
    private $productoRepository;

    public function __construct(ProductoRepository $prodRep)
    {
        $this->productoRepository = $prodRep;
    }

    function getProductos()
    {
        return $this->productoRepository->findAll();
    }

    function getProducto(string $id){
        return $this->productoRepository->find($id);
    }
}