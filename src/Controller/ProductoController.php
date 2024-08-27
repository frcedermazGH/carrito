<?php
namespace App\Controller;

use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{
    #[Route('/', name: 'listar_productos')] // http://localhost/pp1/carrito/public
    public function listarProductos(ProductoRepository $repository): Response
    {
        $productos = $repository->findAll();
        return $this->render('producto/lista.html.twig', ['productos' => $productos]);
    }
}