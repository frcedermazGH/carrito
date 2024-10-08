<?php

namespace App\Controller;

use App\Manager\OrdenManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrdenController extends AbstractController
{
    #[Route('/orden/agregar', name: 'agregar_producto')]
    public function agregarProducto(OrdenManager $ordenManager, Request $request): RedirectResponse
    {
        $idProducto = $request->request->get('idProducto');
        $cantidad = $request->request->get('cantidad');
        $usuario = $this->getUser();

        $ordenManager->agregarProducto($usuario, $idProducto, $cantidad);
        $this->addFlash('notice', 'Se ingreso a la orden ' . $cantidad . ' unidades del producto ' . $idProducto);
        return $this->redirectToRoute('listar_productos');
    }
}
