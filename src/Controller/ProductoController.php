<?php
namespace App\Controller;

use App\Manager\ProductoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{
    #[Route('/', name: 'listar_productos')] // http://localhost/pp1/carrito/public
    public function listarProductos(ProductoManager $productManager): Response
    {
        $productos = $productManager->getProductos();
        return $this->render('producto/lista.html.twig', ['productos' => $productos]);
    }

    #[Route('/producto/{id}', name: 'detalle_producto')]
    public function detalleProducto(ProductoManager $productManager, string $id): Response
    {
        $producto = $productManager->getProducto($id);
        return $this->render('producto/detalle.html.twig', ['producto' => $producto]);
    }
}