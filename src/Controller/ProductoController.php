<?php
namespace App\Controller;

use App\Repository\ProductoRepository;
use ProductoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{
    #[Route('/', name: 'listar_productos')] // http://localhost/pp1/carrito/public
    public function listarProductos(ProductoRepository $repository): Response
    {
        $productManager = new ProductoManager($repository);
        $productos = $productManager->getProductos();
        return $this->render('producto/lista.html.twig', ['productos' => $productos]);
    }
}