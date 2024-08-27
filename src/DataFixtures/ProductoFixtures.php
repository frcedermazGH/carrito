<?php

namespace App\DataFixtures;

use App\Entity\Producto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $product = new Producto();
            $product->setNombre("Fanta".$i);
            $product->setDescripcion("Muy rica");
            $product->setPrecio(mt_rand(10, 100));
            $product->setImagen("images/producto" . $i . ".jpg");
            $manager->persist($product);
        }

        $manager->flush();
    }
}
