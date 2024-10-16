<?php

namespace App\Controller;

use App\Manager\OrdenManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/orden/ver', name: 'ver_orden')]
    public function verOrden(OrdenManager $ordenManager): Response
    {
        $usuario = $this->getUser();
        $orden = $ordenManager->verOrden($usuario);
        if (!$orden) {
            $this->addFlash('notice', 'No tenés una orden en curso.');
            return $this->redirectToRoute('listar_productos');
        }
        return $this->render('orden/resumen.html.twig', [
            'orden' => $orden,
        ]);
    }

    #[Route('/orden/finalizar', name: 'finalizar_compra')]
    public function finalizarCompra(OrdenManager $ordenManager): RedirectResponse
    {
        $usuario = $this->getUser();
        $ordenManager->finalizarCompra($usuario);
        $this->addFlash('notice', 'Compra finalizada con éxito.');
        return $this->redirectToRoute('listar_productos');
    }

    
    #[Route('/orden/eliminar/{idItem}', name: 'eliminar_item')]
    public function eliminarItem(OrdenManager $ordenManager, string $idItem): RedirectResponse
    {
        $usuario = $this->getUser();
        $ordenManager->eliminarItem($usuario, $idItem);
        return $this->redirectToRoute('ver_orden');
    }

    #[Route('/orden/vaciar', name: 'vaciar_orden')]
    public function vaciarOrden(OrdenManager $ordenManager): RedirectResponse
    {
        $usuario = $this->getUser();
        $ordenManager->vaciarOrden($usuario);
        return $this->redirectToRoute('ver_orden');
    }
}
